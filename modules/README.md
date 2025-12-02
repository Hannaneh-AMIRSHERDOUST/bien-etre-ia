# Omeka S Modules

This folder contains custom modules for the Bien-Être IA project.

## Installation

Copy these module folders to your Omeka S installation:

```
modules/BienEtre → [omeka-installation]/modules/BienEtre
modules/BienEtreBot → [omeka-installation]/modules/BienEtreBot
```

Then go to the Omeka S admin panel → Modules → Install and activate them.

## BienEtre Module

A form-based module for creating well-being exercises in Omeka S.

- **Route**: `/bien-etre` and `/bien-etre/create`
- **Features**: HTML form to create exercises with custom vocabulary (beo:)

## BienEtreBot Module

An AI-powered chatbot that recommends exercises based on user emotions.

- **Route**: `/bien-etre-bot`
- **Features**: 
  - Ollama AI integration for natural language understanding
  - Emotion detection
  - Exercise recommendations
  - Fallback to keyword matching if Ollama unavailable

### Ollama Setup

1. Install Ollama: https://ollama.ai
2. Download a model: `ollama pull llama3.2`
3. Ensure Ollama is running (automatically starts or run `ollama serve`)

The chatbot uses `http://localhost:11434/api/generate` to communicate with Ollama.
