<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAIService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client,
                                #[Autowire('%openai_api_key')] string $apiKey,)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function generateCour(string $sujet, string $niveau): ?string
    {
        $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions',
            [
            'headers' => [
                'Authorization' => "Bearer ".$this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4',
                'messages' => [['role' => 'user', 'content' =>
//                    'créer un cours ayant pour sujet : "%$" avec une description de niveau "%$"',
//                    sprintf(
//                        $course->getTitle(),
//                        $course->getNiveau()
//                    )
                    "créer un cours ayant pour sujet : ".$sujet." avec une description de niveau "
                    .$niveau." et revons le moi sous format Json contenant title, description et niveau"
                ]],
                'temperature' => 0.7,
            ],
        ]);

        $data = $response->toArray();

        return $data['choices'][0]['message']['content'] ?? null;
    }

    public function generateQCM(string $sujet, string $numb, string $niveau): ?string
    {
        $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions',
            [
                'headers' => [
                    'Authorization' => "Bearer ".$this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => [['role' => 'user', 'content' =>
                        "genere moi un qcm sur ".$sujet." de niveau ".$niveau." avec ".$numb." 
                        questions et renvoie le moi sous format Json contenant title, questions et niveau"
                    ]],
                    'temperature' => 0.7,
                ],
            ]);

        $data = $response->toArray();

        return $data['choices'][0]['message']['content'] ?? null;
    }

    public function generateExercice(string $sujet, string $niveau): ?string
    {
        $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions',
            [
                'headers' => [
                    'Authorization' => "Bearer ".$this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => [['role' => 'user', 'content' =>
                        "genere moi un exercie sur ".$sujet." de niveau ".$niveau."
                        et renvoie le moi sous format Json contenant title, question et niveau"
                    ]],
                    'temperature' => 0.7,
                ],
            ]);

        $data = $response->toArray();

        return $data['choices'][0]['message']['content'] ?? null;
    }

    public function generateAnswer(string $exercie): ?string
    {
        $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions',
            [
                'headers' => [
                    'Authorization' => "Bearer sk-oD2B8KzwVuKgy1t5XyW4QLXTVmpLKnSTZp-szq8adwT3BlbkFJKI54Aap0IkZNxVE018wM5Dw_kyQw6hOTDznELOBeIA",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => [['role' => 'user', 'content' => "corige cette exercice : ".$exercie
                    ]],
                    'temperature' => 0.7,
                ],
            ]);

        $data = $response->toArray();

        return $data['choices'][0]['message']['content'] ?? null;
    }
}
