<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CreateNewPostType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use Symfony\Component\Serializer\SerializerInterface;

class FirstController extends AbstractController
{
    #[Route('/first/posts', name: 'app_first')]
    public function list(): Response
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $this->render('first/listPosts.html.twig',[
            'result'=> json_decode($result, true)
        ]);
    }

    #[Route('/first/posts/{id}', name: 'app_first_id')]
    public function unit(int $id):Response
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $this->render('first/idPosts.html.twig',[
            'result'=> json_decode($result, true)
        ]);
    }

    #[Route('/first/newPosts', name: 'app_first_new')]
    public function new(Request $request, EntityManagerInterface $entityManager):Response
    {
        $form = $this->createForm(CreateNewPostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ch = curl_init('https://jsonplaceholder.typicode.com/posts');

            // Define the data to be sent in the POST request
            $data = [
                'id'=> 102,
                'title' => $form->get('title')->getData(),
                'body' => $form->get('body')->getData(),
                'userId' => $form->get('userId')->getData(),
            ];

            // Set the options for the cURL handle
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
            curl_setopt($ch, CURLOPT_POST, true); // Set the request method to POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set the request body
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=UTF-8',
            ]); // Set the request headers

            // Execute the cURL request and get the response
            $response = curl_exec($ch);

            // Check for errors
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }

            // Close the cURL handle
            curl_close($ch);

            // Decode the JSON response
            $jsonResponse = json_decode($response, true);

            // Print the response (for debugging purposes)
            print_r($jsonResponse);
        }

        return $this->render('first/newPosts.html.twig',[
            'form'=>$form
        ]);
    }

    #[Route('/first/updatePosts/{id}', name: 'app_first_update')]
    public function update(Request $request, int $id, SerializerInterface $serializer):Response
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $form = $this->createForm(CreateNewPostType::class,$serializer->deserialize($result, Post::class, 'json'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // URL to which the PUT request will be made
            $url = 'https://jsonplaceholder.typicode.com/posts/'.$id;

            // Data to be sent in the PUT request
            $data = [
                'id' => $id,
                'title' => $form->get('title')->getData(),
                'body' => $form->get('body')->getData(),
                'userId' => $form->get('userId')->getData(),
            ];

            // JSON encode the data
            $jsonData = json_encode($data);

            // Create a cURL handle
            $ch = curl_init($url);

            // Set the options for the cURL handle
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Set the request method to PUT
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Set the request body
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=UTF-8',
                'Content-Length: ' . strlen($jsonData),
            ]); // Set the request headers

            // Execute the cURL request and get the response
            $response = curl_exec($ch);

            // Check for errors
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }

            // Close the cURL handle
            curl_close($ch);

            // Decode the JSON response
            $jsonResponse = json_decode($response, true);

            // Print the response (for debugging purposes)
            print_r($jsonResponse);
        }

        return $this->render('first/updatePosts.html.twig',[
            'form'=>$form
        ]);
    }
}
