<?php

namespace App\Traits;
trait HttpResponses
{
    public function error404($message)
    {
        return response()->json(['message' => $message], 404);
    }

    public function ok200($message)
    {
        return response()->json(['message' => $message]);
    }

    public function error401($message)
    {
        return response()->json(['message' => $message], 401);
    }

    public function error422($errorMessage)
    {
        return response()->json([
            'message' => $errorMessage,
            'errors' => [
                'product_id' => [$errorMessage]
            ]
        ], 422);
    }
}
