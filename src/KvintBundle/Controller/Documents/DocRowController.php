<?php

namespace KvintBundle\Controller\Documents;

use AppBundle\Utils\MyHelper;
use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\Documents\IncomeDatatable;
use KvintBundle\Datatables\Documents\IncomeRowDatatable;
use KvintBundle\Entity\Documents\DocRow;
use KvintBundle\Entity\Documents\IncomeDocument;
use KvintBundle\Form\Documents\IncomeDocFilterType;
use KvintBundle\Form\Documents\IncomeDocType;
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

        $arr = $em->getRepository("KvintBundle:Documents\DocRow")->deleteRow($row);
        if ($arr[0]['rez'] == 0) {
            $docHead = $em->getRepository('KvintBundle:Documents\GoodsMovingDocument')->updateHeaderByTableValues($row->getDocument()->getKod());
        }
        return new JsonResponse(
            [
                'addRowStatus' => $arr[0]['rez'],
                'docHeader' => $docHead[0],
            ]
        );
    }
}
