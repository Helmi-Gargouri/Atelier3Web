<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    public function index():Response{
        return new Response('Bonjour');
        
    }
    public function showTeacher($name,$id){
        return new Response('Bonjour'.$name.' '.$id);
    }
}
