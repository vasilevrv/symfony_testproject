<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\FormErrorFormatter;
use App\Pagination\PaginatedResult;
use App\Pagination\Paginator\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractController extends BaseController
{
    public function data($data, array $groups = [], int $code = 200): Response
    {
        return $this->json($data, $code, [], [
            'groups' => $groups
        ]);
    }

    public function noContent(): Response
    {
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    public function invalidForm(FormInterface $form): Response
    {
        return new JsonResponse(FormErrorFormatter::getErrors($form), Response::HTTP_BAD_REQUEST);
    }

    public function getPaginatedResult(Request $request, PaginatorInterface $paginator): PaginatedResult
    {
        $page = (int)$request->get('page', 0);
        if ($page < 0) {
            $page = 0;
        }

        $limit = (int)$request->get('limit', 20);
        if ($limit < 1 || $limit > 100) {
            $limit = 20;
        }

        return $paginator->execute($page, $limit);
    }
}