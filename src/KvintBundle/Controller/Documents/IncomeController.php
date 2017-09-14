<?php

namespace KvintBundle\Controller\Documents;

use AppBundle\Utils\MyHelper;
use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\Documents\IncomeDatatable;
use KvintBundle\Entity\Documents\IncomeDocument;
use KvintBundle\Form\Documents\IncomeDocFilterType;
use KvintBundle\Form\Documents\IncomeDocType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncomeController extends KvintFormsController
{
    protected $entity_name = 'kvint_doc_income';
    /**
     * @Route("/documents/income/list/{beginDate}/{endDate}/{wareHouse}/{customer}", options={"expose"=true}, name = "kvint_documents_income_list")
     * @Template()
     */
    public function incomeListAction(Request $request, $beginDate = null, $endDate = null, $wareHouse = null, $customer = null)
    {
        $em = $this->getDoctrine()->getManager('kvint');
        if (!is_null($wareHouse)) {
            $wareHouseEnt = $em->getRepository('KvintBundle:Sklad')->find($wareHouse);
        } else {
            $wareHouseEnt = null;
        }
        if (!is_null($customer)) {
            $customerEnt = $em->getRepository('KvintBundle:Klient')->find($customer);
        } else {
            $customerEnt = null;
        }
        if (!is_null($beginDate)) {
            $beginDateDT = \DateTime::createFromFormat('d.m.Y', $beginDate);
        } else {
            $beginDateDT = new \DateTime('first day of this month');
        }
        if (!is_null($endDate)) {
            $endDateDT = \DateTime::createFromFormat('d.m.Y', $endDate);
        } else {
            $endDateDT = new \DateTime('last day of this month');;
        }

        $form = $this->createForm(IncomeDocFilterType::class, null,
            [
                'em' => $this->getDoctrine()->getManager('kvint'),
                'beginDate' => $beginDateDT,
                'endDate' => $endDateDT,
                'wareHouse' => $wareHouseEnt,
                'customer' => $customerEnt,
            ]
        );

        $filter = null;
        if (!is_null($wareHouseEnt)) {
            $filter[] = [
                'field' => "IDENTITY(incomedocument.wareHouse)",
                'name' => 'wareHouse',
                'value' => $wareHouseEnt->getKod(),
            ];
        }
        if (!is_null($customerEnt)) {
            $filter[] = [
                'field' => "IDENTITY(incomedocument.customer)",
                'name' => 'customer',
                'value' => $customerEnt->getKod(),
            ];
        }
        if(!is_null($beginDateDT) && !is_null($endDateDT)) {
            $filter[] = [
                'field' => "incomedocument.docDate",
                'name' => 'dateBegin',
                'name2' => 'dateEnd',
                'value' => $beginDateDT->format('Y-m-d'),
                'value2' => $endDateDT->format('Y-m-d'),
            ];
        }

        $options = [
            'errTxt' => "Income",
            'filterForm' => $form->createView(),
            'filter' => $filter,
        ];
        $options['return_parameters']['ffo_wareHouse'] = is_null($wareHouseEnt) ? 0 : $wareHouseEnt->getKod();
        $options['return_parameters']['ffo_customer'] = is_null($customerEnt) ? 0 : $customerEnt->getKod();
        $options['return_parameters']['ffo_beginDate'] = $beginDateDT->format('d.m.Y');
        $options['return_parameters']['ffo_endDate'] = $endDateDT->format('d.m.Y');


        return $this->listAction($request, IncomeDatatable::class, $options);
    }

    /**
     * @param IncomeDocument $doc
     *
     * @Route("/documents/income/show/{id}", name = "kvint_documents_income_show", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showIncomeAction(Request $request, IncomeDocument $doc)
    {
        return $this->showAction($request, $doc,
            [
                'errTxt' => 'income document',
                'form_type' => IncomeDocType::class,
                'form_name' => 'docForm',
                'route_return' => 'kvint_documents_income_list',
                'titleTxt' => ' документ приход ' . trim($doc->getDocTitle()),
                'template' =>  '@Kvint/Documents/Income/incomeElement.html.twig',
                'return_parameters' => MyHelper::getPrefixed('ffo', $request->query->all()),
                'form_type_options' => [
                    'em' => $this->getDoctrine()->getManager('kvint'),
                ],
            ]
        );
    }

    /**
     * @param IncomeDocument $doc
     *
     * @Route("/documents/income/edit/{id}", name = "kvint_documents_income_edit", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editIncomeAction(Request $request, IncomeDocument $doc) {
        return $this->editAction($request, $doc,
            [
                'errTxt' => 'income document',
                'entity_name' => 'KvintBundle:Documents\IncomeDocument',
                'form_type' => IncomeDocType::class,
                'form_name' => 'docForm',
                'route_return' => 'kvint_documents_income_list',
                'titleTxt' => '  документ приход ' . trim($doc->getDocTitle()),
                'template' =>  '@Kvint/Documents/Income/incomeElement.html.twig',
                'return_parameters' => MyHelper::getPrefixed('ffo', $request->query->all()),
                'form_type_options' => [
                    'em' => $this->getDoctrine()->getManager('kvint'),
                ],
            ]
        );
    }

    /**
     * @param IncomeDocument $doc
     *
     * @Route("/documents/income/remove/{id}", name = "kvint_documents_income_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeIncomeAction(Request $request, IncomeDocument $doc) {

        if (!$this->hasRight('delete')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Delete " . "Income document element. Access deny"]);
        }

        $em = $this->getDoctrine()->getManager("kvint");
        $doc->markDel();
        $em->flush();
        return $this->redirectToRoute('kvint_documents_income_list', MyHelper::getPrefixed('ffo', $request->query->all()));
    }
}
