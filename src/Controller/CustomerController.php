<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Customer;
use App\Manager\CustomerManager;
use App\Form\Type\Customer as Type;
use App\Model\Customers\Command;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use App\Pagination\Meta;

/**
 * @Route("/api/v1/customers", name="app.customers.")
 * @OA\Tag(name="Customers")
 */
class CustomerController extends AbstractController
{
    private CustomerManager $manager;

    public function __construct(CustomerManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Search customers
     *
     * @Route("", methods={"GET"}, name="get_all")
     * @OA\Parameter(name="page", in="query")
     * @OA\Parameter(name="limit", in="query")
     * @OA\Response(response=200, description="OK", @OA\JsonContent(
     *     @OA\Property(property="meta", ref=@Model(type=Meta::class, groups={"base"})),
     *     @OA\Property(property="items", type="array", @OA\Items(ref=@Model(type=Customer::class, groups={"base"}))))
     * ))
     * @OA\Response(response=400, description="Invalid search params")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response
    {
        $command = new Command\Search();
        $form = $this->createForm(Type\Search::class, $command, ['method' => 'GET']);
        $form->submit($request->query->all(), false);
        if ($form->isSubmitted() && !$form->isValid()) {
            return $this->invalidForm($form);
        }

        $paginator = $this->manager->search($command);
        $result = $this->getPaginatedResult($request, $paginator);

        return $this->data($result, ['base']);
    }

    /**
     * Create a new customer
     *
     * @Route("", methods={"POST"}, name="create", requirements={"id": "^\d+$"})
     * @OA\RequestBody(@Model(type=Type\Create::class))
     * @OA\Response(response=201, description="OK", @Model(type=Customer::class, groups={"base"}))
     * @OA\Response(response=400, description="Invalid data")
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $command = new Command\Create();
        $form = $this->createForm(Type\Create::class, $command);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->invalidForm($form);
        }

        $customer = $this->manager->create($command);

        return $this->data($customer, ['base'], Response::HTTP_CREATED);
    }

    /**
     * Update a existing customer
     *
     * @Route("/{id}", methods={"PUT"}, name="update", requirements={"id": "^\d+$"})
     * @OA\RequestBody(@Model(type=Type\Update::class))
     * @OA\Response(response=201, description="OK", @Model(type=Customer::class, groups={"base"}))
     * @OA\Response(response=400, description="Invalid data")
     * @OA\Response(response=404, description="Not found")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $customer = $this->getCustomer($id);
        $command = new Command\Update();
        $form = $this->createForm(Type\Update::class, $command, ['method' => 'PUT']);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->invalidForm($form);
        }

        $this->manager->update($customer, $command);

        return $this->data($customer, ['base']);
    }

    /**
     * Remove a existing customer
     *
     * @Route("/{id}", methods={"DELETE"}, name="remove")
     * @OA\Response(response=204, description="OK")
     * @OA\Response(response=404, description="Not found")
     * @param int $id
     * @return Response
     */
    public function remove(int $id): Response
    {
        $customer = $this->getCustomer($id);
        $this->manager->remove($customer);

        return $this->noContent();
    }

    /**
     * @param int $id
     * @return Customer
     */
    private function getCustomer(int $id): Customer
    {
        $customer = $this->manager->get($id);
        if (!$customer) {
            throw new NotFoundHttpException();
        }

        return $customer;
    }
}
