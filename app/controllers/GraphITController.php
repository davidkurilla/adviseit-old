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

}