<?php

namespace KvintBundle\Controller\Documents;

use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\Documents\IncomeDatatable;
use KvintBundle\Form\Documents\IncomeDocFilterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

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
            $beginDateDT = null;
        }
        if (!is_null($endDate)) {
            $endDateDT = \DateTime::createFromFormat('d.m.Y', $endDate);
        } else {
            $endDateDT = null;
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
                'field' => "incomedocument.docDateStr",
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

        return $this->listAction($request, IncomeDatatable::class, $options);

    }
}
