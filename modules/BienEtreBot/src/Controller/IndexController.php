<?php
namespace BienEtreBot\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function chatAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return new JsonModel(['error' => 'POST required']);
        }

        $data = json_decode($request->getContent(), true);
        $userMessage = $data['message'] ?? '';

        // Analyze user message using Ollama
        $response = $this->analyzeMessageWithOllama($userMessage);

        return new JsonModel($response);
    }

    private function analyzeMessageWithOllama($userMessage)
    {
        $api = $this->api();

        try {
            // Get all exercises from database
            $allExercises = $api->search('items', ['resource_template_id' => 8])->getContent();
            
            $exerciseList = [];
            foreach ($allExercises as $item) {
                $values = $item->values();
                $exerciseData = [
                    'id' => $item->id(),
                    'title' => (string)$item->displayTitle(),
                    'url' => $item->siteUrl(),
                ];
                
                // Extract properties
                foreach ($values as $property => $valueObjects) {
                    $propertyValues = [];
                    foreach ($valueObjects['values'] as $value) {
                        $propertyValues[] = $value->value();
                    }
                    $exerciseData['properties'][$property] = implode(', ', $propertyValues);
                }
                
                $exerciseList[] = $exerciseData;
            }

            // Build prompt for Ollama
            $exercisesJson = json_encode($exerciseList, JSON_UNESCAPED_UNICODE);
            
            $prompt = "Tu es un assistant bien-être qui recommande des exercices. Voici les exercices disponibles:\n\n";
            $prompt .= $exercisesJson . "\n\n";
            $prompt .= "L'utilisateur dit: \"" . $userMessage . "\"\n\n";
            $prompt .= "Analyse l'émotion de l'utilisateur et recommande 1-3 exercices pertinents. ";
            $prompt .= "Réponds en JSON avec: {\"emotion\": \"...\", \"message\": \"...\", \"exercise_ids\": [1,2,3]}";

            // Call Ollama API
            $ollamaResponse = $this->callOllama($prompt);
            
            if ($ollamaResponse) {
                $aiData = json_decode($ollamaResponse, true);
                
                $recommendedExercises = [];
                if (isset($aiData['exercise_ids'])) {
                    foreach ($exerciseList as $ex) {
                        if (in_array($ex['id'], $aiData['exercise_ids'])) {
                            $recommendedExercises[] = [
                                'id' => $ex['id'],
                                'title' => $ex['title'],
                                'url' => $ex['url']
                            ];
                        }
                    }
                }
                
                return [
                    'message' => $aiData['message'] ?? 'Comment puis-je vous aider?',
                    'exercises' => $recommendedExercises,
                    'emotion' => $aiData['emotion'] ?? null
                ];
            }

            // Fallback to keyword matching if Ollama fails
            return $this->analyzeMessageFallback($userMessage, $exerciseList);

        } catch (\Exception $e) {
            return [
                'message' => "Désolé, j'ai rencontré un problème. Comment puis-je vous aider?",
                'exercises' => [],
                'error' => $e->getMessage()
            ];
        }
    }

    private function callOllama($prompt, $model = 'llama3.2')
    {
        $url = 'http://localhost:11434/api/generate';
        
        $data = [
            'model' => $model,
            'prompt' => $prompt,
            'stream' => false,
            'format' => 'json'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            $result = json_decode($response, true);
            return $result['response'] ?? null;
        }

        return null;
    }

    private function analyzeMessageFallback($message, $exerciseList)
    {
        $message = strtolower($message);

        // Keyword matching for emotions
        $emotions = [
            'stress' => ['stress', 'stressé', 'tendu', 'anxieux', 'angoisse'],
            'fatigue' => ['fatigué', 'épuisé', 'faible', 'crevé'],
            'calme' => ['calme', 'relax', 'détente', 'zen', 'paisible'],
            'énergie' => ['énergie', 'dynamique', 'motivé', 'actif']
        ];

        $detectedEmotion = null;
        foreach ($emotions as $emotion => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    $detectedEmotion = $emotion;
                    break 2;
                }
            }
        }

        $exercises = [];
        if ($detectedEmotion) {
            // Search exercises matching emotion
            foreach ($exerciseList as $ex) {
                if (isset($ex['properties'])) {
                    foreach ($ex['properties'] as $prop => $val) {
                        if (stripos($val, $detectedEmotion) !== false) {
                            $exercises[] = [
                                'id' => $ex['id'],
                                'title' => $ex['title'],
                                'url' => $ex['url']
                            ];
                            break;
                        }
                    }
                }
                if (count($exercises) >= 3) break;
            }
        }

        // Random exercises if no matches
        if (empty($exercises)) {
            $exercises = array_slice(array_map(function($ex) {
                return [
                    'id' => $ex['id'],
                    'title' => $ex['title'],
                    'url' => $ex['url']
                ];
            }, $exerciseList), 0, 3);
        }

        $botMessage = $detectedEmotion 
            ? "Je comprends que vous ressentez du " . $detectedEmotion . ". Voici des exercices recommandés:"
            : "Voici quelques exercices qui pourraient vous intéresser:";

        return [
            'message' => $botMessage,
            'exercises' => $exercises,
            'emotion' => $detectedEmotion
        ];
    }
}
