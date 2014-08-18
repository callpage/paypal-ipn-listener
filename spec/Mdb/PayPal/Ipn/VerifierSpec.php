<?php

namespace spec\Mdb\PayPal\Ipn;

use Mdb\PayPal\Ipn\ApiAdapter;
use Mdb\PayPal\Ipn\Message;
use Mdb\PayPal\Ipn\Verifier;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VerifierSpec extends ObjectBehavior
{
    function let(
        ApiAdapter $apiAdapter
    )
    {
        $this->beConstructedWith($apiAdapter);
    }

    function it_should_return_true_when_an_ipn_message_is_verified(
        Message $message,
        ApiAdapter $apiAdapter
    )
    {
        $apiAdapter->verifyIpnMessage(
            Argument::type('Mdb\PayPal\Ipn\Message')
        )->willReturn(Verifier::STATUS_KEYWORD_VERIFIED);

        $this->verify($message)->shouldReturn(true);
    }

    function it_should_return_false_when_an_ipn_message_is_invalid(
        Message $message,
        ApiAdapter $apiAdapter
    )
    {
        $apiAdapter->verifyIpnMessage(
            Argument::type('Mdb\PayPal\Ipn\Message')
        )->willReturn(Verifier::STATUS_KEYWORD_INVALID);

        $this->verify($message)->shouldReturn(false);
    }

    function it_should_throw_an_exception_when_an_unexpected_status_keyword_is_encountered(
        Message $message,
        ApiAdapter $apiAdapter
    )
    {
        $apiAdapter->verifyIpnMessage(
            Argument::type('Mdb\PayPal\Ipn\Message')
        )->willReturn('foo');

        $this->shouldThrow('UnexpectedValueException')->duringVerify($message);
    }
}
