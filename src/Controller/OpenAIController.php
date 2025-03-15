<?php

namespace App\Controller;

use App\Service\OpenAIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class OpenAIController extends AbstractController
{
    #[Route('/ai', name: 'app_open_a_i')]
    public function index(): Response
    {
        return $this->render('open_ai/index.html.twig');
    }
    #[Route('/upload', name: 'upload_file', methods: ['POST'])]
    public function upload(Request $request, OpenAIService $openAIService): JsonResponse
    {
        $file = $request->files->get('file');

        if (!$file) {
            return new JsonResponse(['error' => 'No file uploaded'], Response::HTTP_BAD_REQUEST);
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            return new JsonResponse(['error' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.'], Response::HTTP_BAD_REQUEST);
        }

        $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads';
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        $newFilename = uniqid() . '.' . $file->guessExtension();

        try {
        $file->move($uploadsDir, $newFilename);

        $imageContent = file_get_contents($uploadsDir . '/' . $newFilename);
        $imageBase64 = base64_encode($imageContent);

        $rawResponse = $openAIService->detectClothes($imageBase64);

        $cleanedResponse = trim(str_replace(["```json", "```", "\n"], "", $rawResponse));
        $jsonResponse = str_replace("'", '"', $cleanedResponse);
        $detectedItems = json_decode($jsonResponse, true);


            return new JsonResponse([
//                'success' => true,
//                'url' => '/uploads/' . $newFilename,
            ], Response::HTTP_OK);

//        if (!is_array($detectedItems) || empty($detectedItems)) {
//            $this->addFlash('error', "Aucun vêtement détecté");
//        }

        } catch (FileException $e) {
            return new JsonResponse(['error' => 'File upload failed: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
//        return $this->render('open_ai/index.html.twig', [
//            'detectClothes' => $detectedItems
//        ]);