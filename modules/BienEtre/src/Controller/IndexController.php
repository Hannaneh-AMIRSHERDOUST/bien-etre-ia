<?php
namespace BienEtre\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function createAction()
    {
        if (!$this->getRequest()->isPost()) {
            return new ViewModel();
        }
        
        $data = $this->params()->fromPost();
        
        // Use Omeka's API internally (bypasses API key permissions!)
        $api = $this->api();
        
        try {
            $itemData = [
                'o:resource_template' => ['o:id' => 8],
                'dcterms:title' => [
                    [
                        'type' => 'literal',
                        'property_id' => 1,
                        '@value' => $data['title']
                    ]
                ]
            ];
            
            // Add custom properties if they exist
            if (!empty($data['category'])) {
                $itemData['beo:hasCategory'] = [
                    ['type' => 'literal', '@value' => $data['category']]
                ];
            }
            
            if (!empty($data['duration'])) {
                $itemData['beo:duration'] = [
                    ['type' => 'literal', '@value' => $data['duration'] . ' minutes']
                ];
            }
            
            if (!empty($data['material'])) {
                $itemData['beo:neededMaterial'] = [
                    ['type' => 'literal', '@value' => $data['material']]
                ];
            }
            
            if (!empty($data['beforeEmotion'])) {
                $itemData['beo:beforeEmotion'] = [
                    ['type' => 'literal', '@value' => $data['beforeEmotion']]
                ];
            }
            
            if (!empty($data['afterEmotion'])) {
                $itemData['beo:afterEmotion'] = [
                    ['type' => 'literal', '@value' => $data['afterEmotion']]
                ];
            }
            
            if (!empty($data['recommendedFor'])) {
                $itemData['beo:recommendedFor'] = [
                    ['type' => 'literal', '@value' => $data['recommendedFor']]
                ];
            }
            
            if (!empty($data['mediaFile'])) {
                $itemData['beo:mediaFile'] = [
                    ['type' => 'literal', '@value' => $data['mediaFile']]
                ];
            }
            
            // Create item using internal API (no API key needed!)
            $response = $api->create('items', $itemData);
            $item = $response->getContent();
            
            $this->messenger()->addSuccess('Exercice créé avec succès! ID: ' . $item->id());
            
            return $this->redirect()->toRoute('bien-etre');
            
        } catch (\Exception $e) {
            $this->messenger()->addError('Erreur: ' . $e->getMessage());
            return new ViewModel(['error' => $e->getMessage()]);
        }
    }
}
