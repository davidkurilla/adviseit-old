<?php

// CLASS: GraphITController
/**
 * This Class is a controller for GraphIT.
 *
 * @author David Kurilla
 * @version 1.0
 */
class GraphITController
{

    // FUNCTION: getAllCourses
    /**
     * This Function gets all courses from GraphIT.
     * @param String $url - Target URL for GraphIT
     * @return mixed - Associative Array of course data
     */
    public static function getAllCourses(String $url): mixed
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    // FUNCTION: addCourse
    /**
     * This Function adds a course to GraphIT.
     * @param String $url - Target URL for GraphIT
     * @param String $title - Title of the course being added
     * @return void - VOID
     */
    public static function addCourse(String $url, String $title): void
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url.$title);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_exec($ch);
        curl_close($ch);
    }

    public static function getSchedule(String $url): mixed
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $result = curl_exec($ch);

        if ($result === false) {
            // Handle cURL error (e.g., log or return an error response)
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception('cURL request failed: ' . $error);
        }

        curl_close($ch);

        error_log('Raw JSON Response: ' . $result); // Log the raw JSON response

        return json_decode($result, true); // Use true to get an associative array
    }



}