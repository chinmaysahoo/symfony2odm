<?php

namespace Zither\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Zither\StoreBundle\Form\Type\RegistrationType;
use Zither\StoreBundle\Form\Model\Registration;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ZitherStoreBundle:Default:index.html.twig', array('name' => $name));
    }

    public function registerAction()
    {
        $form = $this->createForm(new RegistrationType(), new Registration());

        return $this->render('ZitherStoreBundle:Default:register.html.twig', array('form' => $form->createView()));

    }

    public function createAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            $dm->persist($registration->getUser());
            $dm->flush();

            return $this->redirect($this->generateUrl('zither_store_success'));
    }

        return $this->render('ZitherStoreBundle:Default:register.html.twig', array('form' => $form->createView()));
    }

    public function successAction()
    {
       //return echo "Sucessfully created record!";
    }
}
