<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use TwitchApi\TwitchApi;

final class HomeController extends AbstractController
{

    #[Route('/')]
    public function home(): Response
    {
        $twitch_client_id = $this->getParameter('client_id');
        $twitch_client_secret = $this->getParameter('client_secret');
        $twitch_scopes = $this->getParameter('twitch_scopes');
        $redirect_uri = $this->getParameter('redirect_uri'); 
        
        $helixGuzzleClient = new \TwitchApi\HelixGuzzleClient($twitch_client_id);
        $twitchApi = new \TwitchApi\TwitchApi($helixGuzzleClient, $twitch_client_id, $twitch_client_secret);
        $oauth = $twitchApi->getOauthApi();
       

        if (!isset($_GET['code'])) {
            // Generate the Oauth Uri
            $oauthUri = "https://id.twitch.tv/oauth2/authorize"
                        . "?response_type=code"
                        . "&client_id=$twitch_client_id"
                        . "&redirect_uri=$redirect_uri"
                        . "&scope=$twitch_scopes";
            // Redirect them as there was no auth code
            header("Location: {$oauthUri}");
            exit();
        } else {

                $code = $_GET['code'];
                $token = $oauth->getUserAccessToken($code, $redirect_uri);

                // It is a good practice to check the status code when they've responded, this really is optional though
                if ($token->getStatusCode() == 200) {
                    // Below is the returned token data
                    $data = json_decode($token->getBody()->getContents());

                    // Your bearer token
                    $twitch_access_token = $data->access_token ?? null;
                    // get user infos
                    $user = $this->getTwitchUser($twitch_access_token, $twitchApi);

                    // var_dump($user);
                    // exit;

                    return $this->render('home.html.twig', [
                        'user' => $user,
                        'access_token' => $twitch_access_token,
                        'client_id' => $twitch_client_id
                    ]);


                } else {
                    return 'error retrieving token';
                }
            
        }
    }

    public function getTwitchUser($twitch_access_token, TwitchApi $twitchApi){

        $response = $twitchApi->getUsersApi()->getUserByAccessToken($twitch_access_token);
        // Get and decode the actual content sent by Twitch.
        $responseContent = json_decode($response->getBody()->getContents());
        // Return the first (or only) user.
        return $responseContent->data[0];
        
    }

}

