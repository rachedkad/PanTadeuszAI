<?php
namespace Kasia\Film\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kasia\Film\Entity\Client;
use Kasia\Film\Entity\Film;
use Kasia\Film\Entity\Review;
use Kasia\Film\Entity\Orders;
use Kasia\Film\Form\ClientType;
use Kasia\Film\Form\ReviewType;
use Kasia\Film\Form\OrdersType;
class DefaultController extends Controller
{
    private $mid;
/**
 * Menu action.
 * @Route("/" , name="home")
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:home.html.twig")
 */
    public function homeAction()
    {
        return $this->render('KasiaFilm:Default:home.html.twig', array());
    }
/**
 * first film action.
 * @Route("/first" , name="first" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:first.html.twig")
 */
     public function oneAction()
    {
        return $this->render('KasiaFilm:Default:first.html.twig', array());
    }
    /**
 * hobbit film action.
 * @Route("/hobbit" , name="hobbit" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:hobbit.html.twig")
 */
     public function hobbitAction()
    {
        return $this->render('KasiaFilm:Default:hobbit.html.twig', array());
    }
 /**
 * signup action.
 * @Route("/signup" , name="signup" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:singup.html.twig")
 */
 
     public function createAction(Request $request)
    {
       
 $entity = new Client();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('login'));
        }
       return $this->render('KasiaFilm:Default:signup.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        )); 
     }
        
         private function createCreateForm(Client $entity)
    {
        $form = $this->createForm(new ClientType(), $entity, array(
            'action' => $this->generateUrl('signup'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }
    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new Client();
        $form   = $this->createCreateForm($entity);
        return $this->render('KasiaFilm:Default:singup.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
}
     // public function reviewAction()
     // {
     //     return $this->render('KasiaFilm:Default:review.html.twig', array());
     // }
public function getRefererRoute()
  {
    $request = $this->getRequest();
    //look for the referer route
    $referer = $request->headers->get('referer');
    $lastPath = substr($referer, strpos($referer, $request->getBaseUrl()));
    $lastPath = str_replace($request->getBaseUrl(), '', $lastPath);
    $matcher = $this->get('router')->getMatcher();
    $parameters = $matcher->match($lastPath);
    $route = $parameters['_route'];
    return $route;
  }
public function reviewAction(Request $request){
  $refleksja = new Review();
        $refleksja->setAuthor($this->getUser()->getUsername());
        $form = $this->createForm(new ReviewType(), $refleksja);
        if ($request->isMethod('POST')
                && $form->handleRequest($request)
                && $form->isValid()
                ) {
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($refleksja);
                        $em->flush();
        //                 $ruta = $this->getRefererRoute();
        // $locale = $request->get('_locale');
        // $url = $this->get('router')->generate($ruta, array('_locale' => $locale));
        // $this->getRequest()->getSession()->setFlash('notice', "your_message");   
        // return $this->redirect($url);
             
                         
                        return $this->redirect($this->generateUrl('home', array()));
                }
        return $this->render('KasiaFilm:Default:review.html.twig',  array('form' => $form->createView()));
    }
       
 public function listreviewsAction()
{
        $em = $this->getDoctrine()->getManager();
        $refleksjeRepository = $em->getRepository("KasiaFilm:Review");
        $refleksja = $refleksjeRepository->findAll();
        return $this->render('KasiaFilm:Default:listreviews.html.twig', array('review' => $refleksja));
    
    //   $product = $this->getDoctrine()
    //     ->getRepository('Kasia\Film:Review')
    //     ->find($id);
    // if (!$product) {
    //     throw $this->createNotFoundException(
    //         'No product found for id '.$id
    //     );
    // }
    // ... do something, like pass the $product object into a template
}
    
        public function loginAction(Request $request)
    {
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        return $this->render(
            'KasiaFilm:Default:login.html.twig',
            array(
                'error'         => $error,
            )
        );
    }
     public function loginCheckAction()
    {
    }
    
    /**
 * all film action.
 * @Route("/all" , name="all" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Films:all.html.twig")
 */
     public function allAction()
    {
        return $this->render('KasiaFilm:Films:all.html.twig', array());
    }
      /**
 * action film action.
 * @Route("/action" , name="action" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Films:action.html.twig")
 */
     public function actionAction()
    {
        return $this->render('KasiaFilm:Films:action.html.twig', array());
    }
 /**
 * comedy film action.
 * @Route("/comedy" , name="comedy" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Films:comedy.html.twig")
 */
     public function comedyAction()
    {
        return $this->render('KasiaFilm:Films:comedy.html.twig', array());
    }
     /**
 * drama film action.
 * @Route("/drama" , name="drama" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Films:drama.html.twig")
 */
     public function dramaAction()
    {
        return $this->render('KasiaFilm:Films:drama.html.twig', array());
    }
     /**
 * fantasy film action.
 * @Route("/fantasy" , name="fantasy" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Films:fantasy.html.twig")
 */
     public function fantasyAction()
    {
        return $this->render('KasiaFilm:Films:fantasy.html.twig', array());
    }
     /**
 * mystery film action.
 * @Route("/mystery" , name="mystery" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Films:mystery.html.twig")
 */
     public function mysteryAction()
    {
        return $this->render('KasiaFilm:Films:mystery.html.twig', array());
    }
         /**
 * scifi film action.
 * @Route("/scifi" , name="scifi" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Films:scifi.html.twig")
 */
     public function scifiAction()
    {
        return $this->render('KasiaFilm:Films:scifi.html.twig', array());
    }
 /**
 * borrow film action.
 * @Route("/borrow" , name="borrow" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:borrow.html.twig")
 */
     public function borrowAction(Request $request)
    {
        $refleksja = new Orders();
        $refleksja->setClientname($this->getUser()->getUsername());
        $form = $this->createForm(new OrdersType(), $refleksja);
        if ($request->isMethod('POST')
                && $form->handleRequest($request)
                && $form->isValid()
                ) {
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($refleksja);
                        $em->flush();
   
                         return $this->redirect($this->generateUrl('home', array()));
                }
        return $this->render('KasiaFilm:Default:borrow.html.twig',  array('form' => $form->createView()));
    
       
    
}
public function listorderAction()
{
 //$usr= $this->get('security.context')->getToken()->getUser();
// $usr->getUsername();
// // $username = $this->getUser()->getUsername();
         $em = $this->getDoctrine()->getManager();
       $refleksjeRepository = $em->getRepository("KasiaFilm:Orders");
        $refleksja = $refleksjeRepository->findAll();
//         $refleksja = $refleksjeRepository->findOneBy(array('clientname' => $usr));
   return $this->render('KasiaFilm:Default:listorder.html.twig', array('orders' => $refleksja));
    
}
 /**
     * @Route("/show/{clientname}", name="show")
     * @Template()
     */
    public function showAction($clientname)
    {
        $session = $this->getRequest()->getSession();
        $clientname= $this->get('security.context')->getToken()->getUser();
        $clientname = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KasiaFilm:Orders')->findByClientname($clientname);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clients order .');
        }
       
        return $this->render('KasiaFilm:Default:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
/**
     * @Route("/about/{clientname}", name="about")
     * @Template()
     */
 public function aboutAction($clientname)
    {
        $session = $this->getRequest()->getSession();
        $clientname= $this->get('security.context')->getToken()->getUser();
        $clientname = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KasiaFilm:Client')->findByUsername($clientname);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clients order .');
        }
       
        return $this->render('KasiaFilm:Default:about.html.twig', array(
            'entity'      => $entity,
        ));
    }
/**
     * @Route("/watch/{clientname}", name="watch")
     * @Template()
     */
     public function watchAction($clientname)
    {
       $session = $this->getRequest()->getSession();
        $clientname= $this->get('security.context')->getToken()->getUser();
        $clientname = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KasiaFilm:Orders')->findByClientname($clientname);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Clients order .');
        }
       
        return $this->render('KasiaFilm:Default:watch.html.twig', array(
            'entity'      => $entity,
        ));
    }
  /**
 * online film action.
 * @Route("/online" , name="online" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:online.html.twig")
 */
     public function onlineAction()
    {
        return $this->render('KasiaFilm:Default:online.html.twig', array());
    }
/**
 * bird film action.
 * @Route("/bird" , name="bird" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:bird.html.twig")
 */
     public function birdAction()
    {
        return $this->render('KasiaFilm:Default:bird.html.twig', array());
    }
/**
 * div film action.
 * @Route("/div" , name="div" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:div.html.twig")
 */
     public function divAction()
    {
        return $this->render('KasiaFilm:Default:div.html.twig', array());
    }
/**
 * edge film action.
 * @Route("/edge" , name="edge" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:edge.html.twig")
 */
     public function edgeAction()
    {
        return $this->render('KasiaFilm:Default:edge.html.twig', array());
    }
/**
 * gone film action.
 * @Route("/gone" , name="gone" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:gone.html.twig")
 */
     public function goneAction()
    {
        return $this->render('KasiaFilm:Default:gone.html.twig', array());
    }
/**
 * gurd film action.
 * @Route("/gurd " , name="gurd" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:gurd.html.twig")
 */
     public function gurdAction()
    {
        return $this->render('KasiaFilm:Default:gurd.html.twig', array());
    }
/**
 * hung film action.
 * @Route("/hung " , name="hung" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:hung.html.twig")
 */
     public function hungAction()
    {
        return $this->render('KasiaFilm:Default:hung.html.twig', array());
    }
    /**
 * int film action.
 * @Route("/int " , name="int" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:int.html.twig")
 */
     public function intAction()
    {
        return $this->render('KasiaFilm:Default:int.html.twig', array());
    }
       /**
 * jur film action.
 * @Route("/jur " , name="jur" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:jur.html.twig")
 */
     public function jurAction()
    {
        return $this->render('KasiaFilm:Default:jur.html.twig', array());
    }
           /**
 * king film action.
 * @Route("/king " , name="king" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:king.html.twig")
 */
     public function kingAction()
    {
        return $this->render('KasiaFilm:Default:king.html.twig', array());
    }
               /**
 * luce film action.
 * @Route("/luce " , name="luce" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:luce.html.twig")
 */
     public function luceAction()
    {
        return $this->render('KasiaFilm:Default:luce.html.twig', array());
    }
              /**
 * maze film action.
 * @Route("/maze " , name="maze" )
 * @Method({"GET", "POST"})
 * @Template("KasiaFilm:Default:maze.html.twig")
 */
     public function mazeAction()
    {
        return $this->render('KasiaFilm:Default:maze.html.twig', array());
    }
}