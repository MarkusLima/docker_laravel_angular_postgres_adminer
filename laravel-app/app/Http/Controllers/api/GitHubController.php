<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GitHubUserService;
use App\Services\LogsService;
use App\Http\Requests\NameRequest;
use App\Http\Requests\UserQueryRequest;
use App\Http\Requests\GetLogsRequest;
use App\Models\LogRequest;


class GitHubController extends Controller
{

    protected GitHubUserService $gitHubUserService;
    protected LogsService $logsService;

    // contrutor to initialize any services or dependencies
    public function __construct()
    {
        // You can initialize services here if needed
        $this->gitHubUserService = new GitHubUserService();
        $this->logsService = new LogsService();
    }

    /**
     * Fetches a GitHub user by username.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getUser(NameRequest $request)
    {
        try {
  
            $user = $this->gitHubUserService->getUser($request->userName);
            return response()->json($user);

        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);

        }
    }

    /**
     * Fetches the list of users that a given GitHub user is following.
     *
     * @param UserQueryRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getFollowing(UserQueryRequest $request)
    {
        
        try {
            
            $data = $request->validatedWithDefaults();
            $followers = $this->gitHubUserService->getFollowing($data);
            return response()->json($followers);

        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);

        }
    }

    /**
     * Placeholder method to return logs.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLogs(GetLogsRequest $request)
    {

        try {
            
            $data = $request->validatedWithDefaults();
            $logs = $this->logsService->getLogs($data);
            return response()->json($logs);
            
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()], 400);

        }

    }
}

