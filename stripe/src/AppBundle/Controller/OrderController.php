<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends BaseController
{
    /**
     * @Route("/cart/product/{slug}", name="order_add_product_to_cart")
     * @Method("POST")
     */
    public function addProductToCartAction(Product $product)
    {
        $this->get('shopping_cart')
            ->addProduct($product);

        $this->addFlash('success', 'Product added!');

        return $this->redirectToRoute('order_checkout');
    }

    /**
     * @Route("/checkout", name="order_checkout")
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @return Response
     */
    public function checkoutAction(Request $request)
    {
        $products = $this->get('shopping_cart')->getProducts();
        if ($request->isMethod('POST')) {
            dump($request->get('stripeToken'));
        }

        return $this->render('order/checkout.html.twig', array(
            'products' => $products,
            'cart' => $this->get('shopping_cart')
        ));

    }
}
