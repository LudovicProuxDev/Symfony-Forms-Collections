<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Form\TeamCompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'title' => 'Test Data & JS Containers',
        ]);
    }

    #[Route('/companies', name: 'app_companies')]
    public function companies(CompanyRepository $companyRepository): Response
    {
        return $this->render('index/companies.html.twig', [
            'title' => 'Companies',
            'companies' => $companyRepository->findAll(),
        ]);
    }

    #[Route('/company/{id}', name: 'app_company')]
    public function company(Request $request, EntityManagerInterface $entityManager, Company $company): Response
    {
        $form = $this->createForm(TeamCompanyType::class,$company);
        $form->handleRequest($request);

        //dd($company);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($company);

            foreach($company->getTeams() as $team) {
                $team->setCompany($company);
                $entityManager->persist($team);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('index/company.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/data-list', name: 'app_data_list')]
    public function dataList(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class,$company);
        $form->handleRequest($request);

        //dd($company);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($company);

            foreach($company->getTeams() as $team) {
                $team->setCompany($company);
                $entityManager->persist($team);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('index/data-list.html.twig', [
            'title' => 'Data',
            'form' => $form,
        ]);
    }

    #[Route('/data-table', name: 'app_data_table')]
    public function dataTable(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class,$company);
        $form->handleRequest($request);

        //dd($company);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($company);

            foreach($company->getTeams() as $team) {
                $team->setCompany($company);
                $entityManager->persist($team);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('index/data-table.html.twig', [
            'title' => 'Data',
            'form' => $form,
        ]);
    }
}
