<?php

namespace KvintBundle\Controller\Documents;

use AppBundle\Utils\MyHelper;
use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\Documents\IncomeDatatable;
use KvintBundle\Datatables\Documents\IncomeRowDatatable;
use KvintBundle\Entity\Documents\DocRow;
use KvintBundle\Entity\Documents\GoodsMovingDocument;
use KvintBundle\Entity\Documents\IncomeDocument;
use KvintBundle\Entity\Tovar;
use KvintBundle\Form\Documents\IncomeAddRowType;
use KvintBundle\Form\Documents\IncomeDocFilterType;
use KvintBundle\Form\Documents\IncomeDocType;
use KvintBundle\Form\Documents\IncomeRowType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DocRowController extends KvintFormsController
{
    protected $entity_name = 'kvint_doc_income';

    /**
     * @param IncomeDocument $doc
     *
     * @Route("/documents/docrow/delete/{id}", name = "kvint_doc_row_delete", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function deleteRowAction(Request $request, DocRow $row) {
        if (!$this->hasRight('delete')) {
            return new JsonResponse(['text' => "Deleting document row. Access deny"]);
        }
        $em = $this->getDoctrine()->getManager('kvint');
//        $em->remove($row);
//        $em->flush();

        $arr = $em->getRepository("KvintBundle:Documents\DocRow")->deleteRow($row,
            [
                'user_name' => $this->getUser()->getUserName(),
                'comp_name' => $request->getHost(),
            ]
        );
        if ($arr[0]['rez'] == 0) {
            $docHead = $em->getRepository('KvintBundle:Documents\GoodsMovingDocument')->updateHeaderByTableValues($row->getDocument()->getKod(),
                $this->getUser()->getUserName(), $request->getHost());
        }
        return new JsonResponse(
            [
                'addRowStatus' => $arr[0]['rez'],
                'docHeader' => $docHead[0],
            ]
        );
    }

    /**
     * @Route("/documents/income/row_edit/{id}", name = "kvint_documents_income_rowedit", options = {"expose" = true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template("KvintBundle:Documents/Income:rowForm.html.twig")
     */
    public function RowFormAction(Request $request, DocRow $row) {
        $form = $this->createForm(IncomeRowType::class, $row);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $row = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");

            $arr = $em->getRepository("KvintBundle:Documents\DocRow")->updateRow($row,
                [
                    'user_name' => $this->getUser()->getUserName(),
                    'comp_name' => $request->getHost(),
                ]
            );
            if ($arr[0]['rez'] == 0) {
                $docHead = $em->getRepository('KvintBundle:Documents\GoodsMovingDocument')->updateHeaderByTableValues($row->getDocument()->getKod(),
                    $this->getUser()->getUserName(), $request->getHost());
            }
            return new JsonResponse(
                [
                    'addRowStatus' => $arr[0]['rez'],
                    'docHeader' => $docHead[0],
                ]
            );
        }
        $formReturn = $this->render("KvintBundle:Documents/Income:rowForm.html.twig",[
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
     * @Route("/documents/income/row_add/{id}", name = "kvint_documents_income_rowadd", options = {"expose" = true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template("KvintBundle:Documents/Income:addRowForm.html.twig")
     */
    public function RowFormAddAction(Request $request, GoodsMovingDocument $doc) {
        $row = (new DocRow())->setSupplier($doc->getCustomer())->setTovar((new Tovar())->initEmptyForChoice())
            ->setDocument($doc);
        $em = $this->getDoctrine()->getManager("kvint");
        $form = $this->createForm(IncomeAddRowType::class, $row, [
            'em' => $em,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $row = $form->getData();

            $arr = $em->getRepository("KvintBundle:Documents\DocRow")->addRow($row,
                [
                    'user_name' => $this->getUser()->getUserName(),
                    'comp_name' => $request->getHost(),
                ]
            );
            if ($arr[0]['rez'] == 0) {
                $docHead = $em->getRepository('KvintBundle:Documents\GoodsMovingDocument')->updateHeaderByTableValues($row->getDocument()->getKod(),
                    $this->getUser()->getUserName(), $request->getHost());
            }
            return new JsonResponse(
                [
                    'addRowStatus' => $arr[0]['rez'],
                    'docHeader' => $docHead[0],
                ]
            );
        }

        $formReturn = $this->render("@Kvint/Documents/Income/addRowForm.html.twig",[
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
}