public function register(): void
{
    $this->reportable(function (Throwable $e) {
        //
    });
    
    $this->renderable(function (ErrorException $e, $request) {
        if (str_contains($e->getMessage(), 'Attempt to read property "name" on null')) {
            // Log the stack trace to identify where the error is occurring
            \Log::error('Null property access error', [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->fullUrl(),
                'method' => $request->method()
            ]);
            
            // Return a custom error view with debugging info in development
            if (config('app.debug')) {
                return response()->view('errors.custom', [
                    'message' => 'We encountered an error processing your request.',
                    'details' => 'Error in file: ' . $e->getFile() . ' on line ' . $e->getLine()
                ], 500);
            }
            
            // Return a generic error in production
            return response()->view('errors.custom', [
                'message' => 'We encountered an error processing your request.'
            ], 500);
        }
    });
}

