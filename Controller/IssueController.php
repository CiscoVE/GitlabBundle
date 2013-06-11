<?php

namespace CiscoSystems\GitlabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CiscoSystems\GitlabBundle\Model\Issue;
use CiscoSystems\GitlabBundle\Form\Type\IssueType;

class IssueController extends Controller
{
    public function indexAction( Request $request )
    {
        // Process Issue form
        $issue = new Issue();
        $form = $this->createForm( new IssueType(), $issue );
        if ( null !== $formdata = $request->get( 'gitlabissue' ) )
        {
            $form->bindRequest( $request );
            if ( $form->isValid() )
            {
                $access = $this->get( 'gitlab' )->getAccessData( $formdata['access_id'] );
                if ( $access )
                {
                    $response = $this->get( 'gitlab' )->getApi( $access )->createIssue( $issue );
                    if ( $response )
                    {
                        $this->get( 'session' )->getFlashBag()->add( 'gitlab_raised_issue_id', $response['id'] );
                        $this->get( 'session' )->getFlashBag()->add( 'gitlab_notice', 'Issue has been raised.' );
                        return $this->redirect( $this->generateUrl( $request->get('_route') ) );
                    }
                }
            }
        }
        // Render view
        return $this->render( 'CiscoSystemsGitlabBundle:Issue:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function viewAction( Request $request )
    {
//        $access = $this->get( 'gitlab' )->getAccessData( 2 );
//        if ( $access )
//        {
//            $this->get( 'gitlab' )->getApi( $access )->getIssue( 2, 28 );
//        }
        return new Response( 'Not implemented yet' );
    }

    public function deleteAction( Request $request )
    {
//        $access = $this->get( 'gitlab' )->getAccessData( 2 );
//        if ( $access )
//        {
//            $this->get( 'gitlab' )->getApi( $access )->deleteIssue( 2, 28 );
//        }
        return new Response( 'Not implemented yet' );
    }
}
