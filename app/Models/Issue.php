<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function findByJiraIssueId(string $jiraIssueId): Issue
    {
        return self::where("jira_issue_id", $jiraIssueId)
            ->first();
    }
}
