<?php

namespace App\Http\Controllers;

use Cloudinary\Configuration\Configuration;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\ads;
use PDO;
use PDOException;
use PDOStatement;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'df6mzmw3v',
        'api_key' => '288424958781825',
        'api_secret' => 'i7h7hexaT4aHPXJjawSBfkoyHWs'
    ],
    'url' => [
        'secure' => true
    ]
]);

class AdsController extends Controller
{
    public function index()
    {
        return view("ads");
    }

    public function updateAda(Request $request)
    {
        $request->validate([
            'ad' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            if ($request->hasFile('ad')) {
                $response = Cloudinary::upload($request->file('ad')->getRealPath())->getSecurePath();

                $host = env('DB_HOST');
                $dbname = env('DB_DATABASE');
                $username = env('DB_USERNAME');
                $password = env('DB_PASSWORD');

                try {
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // Perform database operations...
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }

                $sql = "UPDATE ads SET url = :url WHERE unique_index = :uniqueIndex";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['url' => $response, 'uniqueIndex' => 1]); // Change the unique index as needed

                // Log successful file upload and database update
                Log::info('File uploaded and ad updated!', [
                    'file_name' => $request->file('ad')->getClientOriginalName(),
                    'file_size' => $request->file('ad')->getSize(),
                    'secure_url' => $response,
                ]);

                // Return JSON response with secure URL
                return response()->json(['success' => true, 'secure_url' => $response]);
            }
        } catch (\Exception $e) {
            // Log the caught exception details
            Log::error('Error occurred while uploading file or updating database: ' . $e->getMessage(), [
                'file_name' => $request->file('ad')->getClientOriginalName(),
                'file_size' => $request->file('ad')->getSize(),
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            // Return JSON response in case of error
            return response()->json(['success' => false, 'error' => 'An error occurred while uploading the file.']);
        }

        // Return JSON response if no file was uploaded
        return response()->json(['success' => false, 'error' => 'No file was uploaded.']);
    }

    public function updateAdb(Request $request)
    {
        $request->validate([
            'ad' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            if ($request->hasFile('ad')) {
                $response = Cloudinary::upload($request->file('ad')->getRealPath())->getSecurePath();
    
                $host = env('DB_HOST');
                $dbname = env('DB_DATABASE');
                $username = env('DB_USERNAME');
                $password = env('DB_PASSWORD');
    
                try {
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // Perform database operations...
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
    
                $sql = "UPDATE ads SET url = :url WHERE unique_index = :uniqueIndex";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['url' => $response, 'uniqueIndex' => 2]); // Change the unique index as needed
    
                // Log successful file upload and database update
                Log::info('File uploaded and ad updated!', [
                    'file_name' => $request->file('ad')->getClientOriginalName(),
                    'file_size' => $request->file('ad')->getSize(),
                    'secure_url' => $response,
                ]);
    
                return back()->with('success', 'File uploaded successfully!');
            }
        } catch (\Exception $e) {
            // Log the caught exception details
            Log::error('Error occurred while uploading file or updating database: ' . $e->getMessage(), [
                'file_name' => $request->file('ad')->getClientOriginalName(),
                'file_size' => $request->file('ad')->getSize(),
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);
    
            return back()->with('error', 'An error occurred while uploading the file.');
        }
    
        return back()->with('error', 'No file was uploaded.');
    }
        public function getAllAds(Request $request)
    {
        $ads = ads::all(); // Retrieve all ads from the database
        $adUrls = $ads->pluck('url'); // Extract only the URLs

        return response()->json(['ads' => $adUrls]);
    }

    public function updateAdc(Request $request)
    {
        $request->validate([
            'ad' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            if ($request->hasFile('ad')) {
                $response = Cloudinary::upload($request->file('ad')->getRealPath())->getSecurePath();
    
                $host = env('DB_HOST');
                $dbname = env('DB_DATABASE');
                $username = env('DB_USERNAME');
                $password = env('DB_PASSWORD');
    
                try {
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // Perform database operations...
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
    
                $sql = "UPDATE ads SET url = :url WHERE unique_index = :uniqueIndex";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['url' => $response, 'uniqueIndex' => 3]); // Change the unique index as needed
    
                // Log successful file upload and database update
                Log::info('File uploaded and ad updated!', [
                    'file_name' => $request->file('ad')->getClientOriginalName(),
                    'file_size' => $request->file('ad')->getSize(),
                    'secure_url' => $response,
                ]);
    
                return back()->with('success', 'File uploaded successfully!');
            }
        } catch (\Exception $e) {
            // Log the caught exception details
            Log::error('Error occurred while uploading file or updating database: ' . $e->getMessage(), [
                'file_name' => $request->file('ad')->getClientOriginalName(),
                'file_size' => $request->file('ad')->getSize(),
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);
    
            return back()->with('error', 'An error occurred while uploading the file.');
        }
    
        return back()->with('error', 'No file was uploaded.');
    }
}
