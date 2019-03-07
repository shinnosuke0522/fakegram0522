<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function top(Request $request)
    {
        $token = $request->session()->get('github_token', null);

        try {
            $user = Socialite::driver('github')->userFromToken($token);
        } catch (\Exception $e) {
            return redirect('login/github');
        }

        return redirect('/home');
    }

    public function createIssue(Request $request)
    {
        $token = $request->session()->get('github_token', null);
        $user = Socialite::driver('github')->userFromToken($token);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://api.github.com/repos/' . $user->user['login'] . '/' . $request->input('repo') . '/issues', [
            'auth' => [$user->user['login'], $token],
            'json' => [
                'title' => $request->input('title'),
                'body' => $request->input('body')
            ]
        ]);

        return view('done', [
            'response' => json_decode($res->getBody())->html_url
        ]);
    }
}
