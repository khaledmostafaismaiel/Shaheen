<?php

namespace App\Apis;

use App\Models\Jira;
use Illuminate\Support\Facades\Http;

class JiraApi
{
    private Jira $jira;
    private string $credentials;

    public function __construct(Jira $jira)
    {
        $this->jira = $jira;

        $username = $this->jira->user_name;
        $password = $this->jira->password;

        $this->credentials = base64_encode("$username:$password");
    }

    public function get(string $url, int $page=1, int $maxResults=100)
    {
        return Http::withHeaders(
            [
                'Authorization' => "Basic $this->credentials",
            ]
        )->get(
            $url,
            [
                'maxResults' => $maxResults,
                'startAt' => ($page - 1) * $maxResults,
            ]
        );
    }
    
}
