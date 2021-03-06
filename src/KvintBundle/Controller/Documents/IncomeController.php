<?php

namespace KvintBundle\Controller\Documents;

use AppBundle\Utils\MyHelper;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\Documents\IncomeDatatable;
use KvintBundle\Datatables\Documents\IncomeRowDatatable;
use KvintBundle\Entity\Documents\DocRow;
use KvintBundle\Entity\Documents\GoodsMovingDocument;
use KvintBundle\Entity\Documents\IncomeDocument;
use KvintBundle\Entity\Klient;
use KvintBundle\Entity\Tovar;
use KvintBundle\Form\Documents\DocStatusType;
use KvintBundle\Form\Documents\IncomeDocFilterType;
use KvintBundle\Form\Documents\IncomeDocType;
use KvintBundle\Form\Documents\IncomeRowType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncomeController extends KvintFormsController
{
    protected $entity_name = 'kvint_doc_income';

    /**
     * @param IncomeDocument $doc
     *
     * @Route("/documents/income/tovarlist/{id}", name = "kvint_documents_income_tovar_list", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function getTovarListAction(Request $request, $id = null) {
        if (!$this->hasRight('view')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "View " . $options['errTxt'] . " dictinary element. Access deny"]);
        }
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(IncomeRowDatatable::class);
//        $datatable->ajaxUrl = $this->generateUrl('kvint_documents_income_tovar_list');
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);

            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();

            $qb = $datatableQueryBuilder->getQb();
//            dump($qb);
            $qb->andWhere('IDENTITY(docrow.document) = :document');
            $qb->setParameter('document', $id);

            return $responseService->getResponse(false);
        }
    }
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
        $options['grd_total'] = false;

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
                'additional_datatables' => [
                    ['name'=>'tovar', 'data_table_type' => IncomeRowDatatable::class, 'ajax_url' => $this->generateUrl('kvint_documents_income_tovar_list', ['id' => $doc->getKod()])],
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
//        foreach($doc->getRows() as $row) {
//            dump($row->getTovar()->getTname());
//        }
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
                'additional_datatables' => [
                    ['name'=>'tovar', 'data_table_type' => IncomeRowDatatable::class, 'ajax_url' => $this->generateUrl('kvint_documents_income_tovar_list', ['id' => $doc->getKod()])],
                ],
                'comp_name' => $request->getHost(),
                'other_options' => [
                    'journal_right' => $this->hasRight('viewChangesJournal'),
                    'journalData' => $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Documents\GoodsMovingDocument')->getRowsDocChangeJournal($doc->getKod()),
                ]
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

    /**
     * @Route("/documents/status/edit/{id}", name = "kvint_documents_status_edit", options = {"expose" = true})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function StatusEditAction(Request $request, GoodsMovingDocument $doc) {
        if (!$this->hasRight('edit')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Delete " . "Income document element. Access deny"]);
        }

        $form = $this->createForm(DocStatusType::class, $doc);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doc = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");

            $em->getRepository('KvintBundle:Documents\GoodsMovingDocument')->processStatusChange($doc, $this->getUser()->getUsername(), $request->getHost());

            $em->persist($doc);
            $em->flush();

            return new JsonResponse(
                [
                    'addRowStatus' => 0//$arr[0]['rez'],
//                    'docHeader' => $docHead[0],
                ]
            );
        }
        $formReturn = $this->render("@Kvint/Documents/Income/docStatusEdit.html.twig",[
            'form' => $form->createView(),
            'type' => 'edit',
        ]);
        return new JsonResponse(
            [
                'addRowStatus' => 1,
                'formReturn' => $formReturn->getContent(),
            ]
        );
    }

    /**
     * @Route("/documents/change/journal/show/{id}", name = "kvint_documents_change_journal", options = {"expose" = true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template("@Kvint/Documents/changeJournal.html.twig")
     */
    public function ViewJournalAction(Request $request, $id) {
        if (!$this->hasRight('viewChangesJournal')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Document journal change. Access deny"]);
        }
        $docData = $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Documents\GoodsMovingDocument')->getGeneralDocChangeJournal($id);
        $rowsData = [];
        return [
            'docData' => $docData,
            'rowsData' => $rowsData,
        ];
    }

    /**
     * @Route("/documents/income/pdf/{id}", name = "kvint_documents_income_pdf", options = {"expose" = true})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function PdfAction(IncomeDocument $doc) {

        $html = $this->renderView('print/document.html.twig', [
            'doc' => $doc->getArrayToPrint(),
        ]);

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }

    /**
     * @Route("/documents/income/print/{id}", name = "kvint_documents_income_print", options = {"expose" = true})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function PrintAction(IncomeDocument $doc) {
        return $this->render('print/document.html.twig', [
            'doc' => $doc->getArrayToPrint(),
        ]);
    }
}