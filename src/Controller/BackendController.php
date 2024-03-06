<?php


namespace App\Controller;

use App\Entity\CategorieService;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\LocalisationGeographique;
use App\Entity\Notification;
use App\Entity\Produit;
use App\Entity\Service;
use App\Entity\User;
use App\Entity\Utilisateur;
use App\Form\CategorieServiceType;
use App\Form\CommandeType;
use App\Form\EditCommandeType;
use App\Form\EditProduitType;
use App\Form\EditUtilisateurType;
use App\Form\LivraisonType;
use App\Form\LocalisationGeographiqueType;
use App\Form\NotificationType;
use App\Form\ProduitType;
use App\Form\ServiceType;
use App\Form\UpdateFormType;
use App\Form\UtilisateurAuthorType;
use App\Repository\CategorieServiceRepository;
use App\Repository\CommandeRepository;
use App\Repository\LivraisonRepository;
use App\Repository\LocalisationGeographiqueRepository;
use App\Repository\NotificationRepository;
use App\Repository\ProduitRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{

    #[Route('/backendHome', name: 'backendHome')]
    public function backendHome(UserRepository $utilisateurRepository): Response
    {
        $user=$utilisateurRepository->findAll();
        return $this->render('backend/backendhome.html.twig', [
            'table' => $user
        ]);
    }

    #Backend CRUD

    #[Route('/displayUsers', name: 'displayUsers')]
    public function displayUsers(UserRepository $utilisateurRepository): Response
    {
        $user=$utilisateurRepository->findAll();
        return $this->render('backend/UsersList.html.twig', [
            'table' => $user
        ]);
    }

    #[Route('/addUser', name: 'addUser')]
    public function addUser(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $user=new User();
        $form=$this->createForm(UtilisateurAuthorType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($user);
            $m->flush();

            return $this->redirectToRoute('displayUsers');
        }
        return $this->render('backend/addUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/editUser/{id}', name: 'editUser')]
    public function editUser(UserRepository $utilisateurRepository, ManagerRegistry $managerRegistry, Request $request,$id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$utilisateurRepository->find($id);
        $form=$this->createForm(EditUtilisateurType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('displayUsers');
        }
        return $this->render('backend/edituserbyid.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/deleteUser/{id}', name: 'deleteUser')]
    public function deleteUser(UserRepository $utilisateurRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$utilisateurRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayUsers');
    }

    # Profile business

    #[Route('/adminProfile', name: 'adminProfile')]
    public function adminProfile(): Response
    {
        return $this->render('backend/adminprofile.html.twig', [
            'controller_name' => 'BackendController',
        ]);
    }
    
    #[Route('/editAdmin', name: 'editAdmin')]
    public function editAdmin(UserRepository $userRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$this->getUser();
        $form=$this->createForm(EditUtilisateurType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('adminProfile');
        }
        return $this->render('backend/editprofile.html.twig', [
            'form' => $form->createView()
        ]);
    }
    

        # PRODUCT BACKEND 

        #[Route('/displayProducts', name: 'displayProducts')]
        public function displayProducts(ProduitRepository $ProduitRepository): Response
        {
            $produit=$ProduitRepository->findAll();
            return $this->render('backend/ProductList.html.twig', [
                'table' => $produit
            ]);
        }
        
        #[Route('/addProduct', name: 'addProduct')]
        public function addProduct(ManagerRegistry $managerRegistry, Request $request): Response
        {
            $m=$managerRegistry->getManager();
            $produit=new Produit();
            $form=$this->createForm(ProduitType::class,$produit);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
    
                $m->persist($produit);
                $m->flush();
    
                return $this->redirectToRoute('displayProducts');
            }
            return $this->render('backend/addProduct.html.twig', [
                'form' => $form->createView()
            ]);
        }
    
        #[Route('/edit/{id}', name: 'edit')]
        public function edit(ProduitRepository $ProduitRepository, ManagerRegistry $managerRegistry, Request $request, $id):Response
        {
            $m=$managerRegistry->getManager();
            $findid=$ProduitRepository->find($id);
            $form=$this->createForm(EditProduitType::class,$findid);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
    
                $m->persist($findid);
                $m->flush();
    
                return $this->redirectToRoute('displayProducts');
            }
            return $this->render('backend/editProductbyid.html.twig', [
                'form' => $form->createView()
            ]);
        }
    
    
        #[Route('/deleteP/{id}', name: 'deleteP')]
    public function deleteP(ProduitRepository $produitRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$produitRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayProducts');
    }
    
    #backendCommande
        #[Route('/displayComd', name: 'displayComd')]
        public function displayComd(CommandeRepository $CommandeRepository): Response
        {
            $cmd=$CommandeRepository->findAll();
            return $this->render('backend/CommandeList.html.twig', [
                'table' => $cmd
            ]);
        }
        #[Route('/addComd', name: 'addComd')]
        public function addComd(ManagerRegistry $managerRegistry, Request $request): Response
        {
            $m=$managerRegistry->getManager();
            $cmd=new Commande();
            $form=$this->createForm(CommandeType::class,$cmd);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
    
                $m->persist($cmd);
                $m->flush();
    
                return $this->redirectToRoute('displayComd');
            }
            return $this->render('backend/addCommande.html.twig', [
                'form' => $form->createView()
            ]);
        }
      
        #[Route('/editc/{id}', name: 'editc')]
        public function editc(CommandeRepository $CommandeRepository, ManagerRegistry $managerRegistry, Request $request, $id):Response
        {
            $m=$managerRegistry->getManager();
            $findid=$CommandeRepository->find($id);
            $form=$this->createForm(EditCommandeType::class,$findid);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
    
                $m->persist($findid);
                $m->flush();
    
                return $this->redirectToRoute('displayComd');
            }
            return $this->render('backend/editCommandebyid.html.twig', [
                'form' => $form->createView()
            ]);
        }
    
    
        #[Route('/deletec/{id}', name: 'deletec')]
        public function deletec(CommandeRepository $CommandeRepository, ManagerRegistry $managerRegistry, $id): Response
        {
            $m=$managerRegistry->getManager();
            $findid=$CommandeRepository->find($id);
            $m->remove($findid);
            $m->flush();
            return $this->redirectToRoute('displayComd');
        }

        # MESSAGERIE BACKEND

    #[Route('/chat', name: 'chat')]
    public function chat(): Response
    {
        return $this->render('backend/chat.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    
    #[Route('/notiflist', name: 'notiflist')]
    public function notiflist(NotificationRepository $notificationRepository): Response
    {   $notif=$notificationRepository->findAll();
        return $this->render('backend/notiflist.html.twig', [
            'table' => $notif,
        ]);
    
    }
#[Route('/addnotif', name: 'addnotif')]
    public function addnotif(ManagerRegistry $managerRegistry,Request $req): Response

    {  
        $em=$managerRegistry->getManager();
        $nt=new Notification();
        $form=$this->createForm(NotificationType::class,$nt);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form ->isValid()){

            $em->persist($nt);
            $em->flush();
            return $this->redirectToRoute('notiflist');
        }
        
    
        return $this->render('backend/addnotif.html.twig', [
        'f'=>$form->createView()
        ]);
    }
    #[Route('/editnotif/{id}', name: 'editnotif')]
    public function editnotif($id,NotificationRepository $notificationRepository ,Request $req,ManagerRegistry $ManagerRegistry): Response
    {
        $em = $ManagerRegistry->getManager();
    // var_dump($id).die();
    $dataid=$notificationRepository->find($id);
    //var_dump($dataid).die();
    $form=$this->createForm(NotificationType::class,$dataid);
    $form->handleRequest($req);
    if($form->isSubmitted() and $form->isValid()){
        $em->persist($dataid);
        $em->flush();
        return $this->redirectToRoute('notiflist');

    }

    return $this->render('backend/editnotif.html.twig', [
        'x'=>$form->createView()
        

    ]);
    }
    #[Route('/deletenotif/{id}', name: 'deletenotif')]
    public function deletenotif($id,NotificationRepository $notificationRepository ,Request $req,ManagerRegistry $ManagerRegistry): Response
    {
        $em = $ManagerRegistry->getManager();
        $dataid=$notificationRepository->find($id);
        $em->remove($dataid);
        $em->flush();
        return $this->redirectToRoute('notiflist');
    
    }

    # SERVICE BACKEND

    #[Route('/showS', name: 'showS')]
    public function showS(ServiceRepository $repo): Response
    {
        
        $service = $repo->findAll();
        return $this->render('backend/serviceList.html.twig', [
            'services' => $service
        ]);
    }

    #[Route('/addservices', name: 'addservices')]
    public function addservices(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $service=new Service();
        $form=$this->createForm(ServiceType::class,$service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($service);
            $m->flush();
            return $this->redirectToRoute('showS');
        }
        return $this->render('backend/addservice.html.twig', [
            'f' => $form->createView()
        ]);
    }

    #[Route('/updateS/{id}', name: 'updateS')]
    public function updateS(ServiceRepository $serviceRepository, ManagerRegistry $managerRegistry, Request $request, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$serviceRepository->find($id);
        $form=$this->createForm(UpdateFormType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('showS');
        }
        return $this->render('backend/editservice.html.twig', [
            'f' => $form->createView()
        ]);
    }
    #[Route('/deleteService/{id}',name:'deleteService')]
    public function deleteService( $id , ManagerRegistry $manager, ServiceRepository $repo):Response{
        $service=$repo->find($id) ;  
        $em= $manager->getManager();
        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute("showS");
    }

    #[Route('/showC', name: 'showC')]
    public function showC(CategorieServiceRepository $repo): Response
    {
        
        $cat = $repo->findAll();
        return $this->render('backend/categorylist.html.twig', [
            'categories' => $cat
        ]);
    }

    #[Route('/addcategories', name: 'addcategories')]
    public function addcategories(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $cat=new CategorieService();
        $form=$this->createForm(CategorieServiceType::class,$cat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($cat);
            $m->flush();
            return $this->redirectToRoute('showC');
        }
        return $this->render('backend/addcategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/updateC/{id}', name: 'updateC')]
    public function updateC(CategorieServiceRepository $serviceRepository, ManagerRegistry $managerRegistry, Request $request, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$serviceRepository->find($id);
        $form=$this->createForm(CategorieServiceType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('showC');
        }
        return $this->render('backend/editcategory.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/deleteCategory/{id}',name:'deleteCategory')]
    public function deleteCategory( $id , ManagerRegistry $manager, CategorieServiceRepository $repo):Response{
        $cat=$repo->find($id) ;  
        $em= $manager->getManager();
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute("showC");
    }

    # DELIVERY BACKEND

    #[Route('/Deliverylist', name: 'Deliverylist')]
    public function Deliverylist(LivraisonRepository $livraisonRepository): Response
    {
        $livraison=$livraisonRepository->findAll();
        return $this->render('backend/Deliverylist.html.twig', [
            'Livraison' => $livraison,
        ]);
    }
    #[Route('/Locationlist', name: 'Locationlist')]
    public function Locationlist(LocalisationGeographiqueRepository $localisationGeographiqueRepository): Response
    {
        $location=$localisationGeographiqueRepository->findAll();
        return $this->render('backend/Locationlist.html.twig', [
            'location' => $location,
        ]);
    }
    #[Route('/annuler', name: 'annuler')]
    public function annuler(): Response
    {
        return $this->redirectToRoute('Deliverylist');
    }
    #[Route('/Back', name: 'Back')]
    public function Back(): Response
    {
        return $this->redirectToRoute('Locationlist');
    }
#Backend CRUD tab Location
    #[Route('/Addlocation', name: 'Addlocation')]
    public function Addlocation(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $w=$managerRegistry->getManager();
        $b=new LocalisationGeographique();
        $form = $this->createForm(LocalisationGeographiqueType::class,$b);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $w->persist($b);
            $w->flush();
            return $this->redirectToRoute('Locationlist');
        }
        return $this->renderForm('backend/Addlocation.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/Editlocation/{id}', name: 'Editlocation')]
    public function Editlocation(LocalisationGeographiqueRepository $localisationGeographiqueRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $t=$managerRegistry->getManager();
        $s=$localisationGeographiqueRepository->find($id);
        $form = $this->createForm(LocalisationGeographiqueType::class,$s);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $t->persist($s);
            $t->flush();
            return $this->redirectToRoute('Locationlist');
        }
        return $this->renderForm('backend/Editlocation.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/Deletelocation/{id}', name: 'Deletelocation')]
    public function Deletelocation(LocalisationGeographiqueRepository $localisationGeographiqueRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $r=$managerRegistry->getManager();
        $em=$localisationGeographiqueRepository->find($id);
        $r->remove($em);
        $r->flush();
        return $this->redirectToRoute('Locationlist');
    }
#Backend CRUD tab Livraison
    #[Route('/Adddelivery', name: 'Adddelivery')]
    public function Adddelivery(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $x=$managerRegistry->getManager();
        $y=new Livraison();
        $form = $this->createForm(LivraisonType::class,$y);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){

            $x->persist($y);
            $x->flush();

            return $this->redirectToRoute('Deliverylist');
        }
        return $this->render('backend/Adddelivery.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/Editdelivery/{id}', name: 'Editdelivery')]
    public function Editdelivery(LivraisonRepository $livraisonRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $t=$managerRegistry->getManager();
        $s=$livraisonRepository->find($id);
        $form = $this->createForm(LivraisonType::class,$s);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $t->persist($s);
            $t->flush();
            return $this->redirectToRoute('Deliverylist');
        }
        return $this->renderForm('backend/Editdelivery.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/DeleteDelivery/{id}', name: 'DeleteDelivery')]
    public function DeleteDelivery(LivraisonRepository $livraisonRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $x=$managerRegistry->getManager();
        $a=$livraisonRepository->find($id);
        $x->remove($a);
        $x->flush();
        return $this->redirectToRoute('Deliverylist');
    }

    #[Route('/adminblockuser/{id}', name: 'app_adminblockuser')]
    public function adminblockuser($id, UserRepository $userRepository, ManagerRegistry $managerRegistry ): Response
    {
        $em = $managerRegistry->getManager();
        $data = $userRepository->find($id);
        $data->setEnabled(!$data->isEnabled());
        $em->persist($data);
        $em->flush();
        return $this->redirectToRoute('displayUsers');  
    }

}
