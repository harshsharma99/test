<?php
 /**
     * Action for adding a System
     *
     * @param int|null $id ID of the System
     *
     * @return Response
     *
     * @Route("/show/{id}/editSystem", requirements={"id" = "\d+"}, name="system_edit")
     * @Route("/add", name="system_add")
     */
    public function addAction($id = null)
    {
        if (is_null($id)) {
            $system = new System();
        } else {
            $system = $this->getSystemId($id);
        }
        $form = $this->createForm(new AddSystemType(), $system);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                /* @var $em \Doctrine\ORM\EntityManager */
                $em = $this->getDoctrine()->getManager();
                $em->persist($system);
                $em->flush();

                return $this->redirect($this->generateUrl('system_show', array('id' => $system->getId())));
            }
        }

        return $this->render('LuneticsSysprofileBundle:System:add.html.twig', array(
            'form'   => $form->createView(),
            'system' => $system
        ));
    }