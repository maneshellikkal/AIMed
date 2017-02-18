<?php

namespace Tests;

use Mail;
use Swift_Events_EventListener;
use Swift_Message;

trait MailTracking
{
    /**
     * Delivered emails.
     */
    protected $emails = [];

    /**
     * Register a listener for new emails.
     * @before
     */
    public function setUpMailTracking ()
    {
        Mail::getSwiftMailer()
            ->registerPlugin(new TestingMailEventListener($this));
    }

    /**
     * Assert that at least one email was sent.
     */
    protected function assertEmailWasSent ()
    {
        return $this->assertNotEmpty(
            $this->emails, 'No emails have been sent.'
        );
    }

    /**
     * Assert that no emails were sent.
     */
    protected function assertEmailWasNotSent ()
    {
        return $this->assertEmpty(
            $this->emails, 'Did not expect any emails to have been sent.'
        );
    }

    /**
     * Assert that the given number of emails were sent.
     *
     * @param integer $count
     */
    protected function assertEmailsSentCount ($count)
    {
        $emailsSent = count($this->emails);

        return $this->assertCount(
            $count, $this->emails,
            "Expected $count emails to have been sent, but $emailsSent were."
        );
    }

    /**
     * Assert that the last email's body equals the given text.
     *
     * @param string        $body
     * @param Swift_Message $message
     */
    protected function assertEmailEquals ($body, Swift_Message $message = null)
    {
        return $this->assertEquals(
            $body, $this->getEmail($message)->getBody(),
            "No email with the provided body was sent."
        );
    }

    /**
     * Assert that the last email's body contains the given text.
     *
     * @param string        $excerpt
     * @param Swift_Message $message
     */
    protected function assertEmailContains ($excerpt, Swift_Message $message = null)
    {
        return $this->assertContains(
            $excerpt, $this->getEmail($message)->getBody(),
            "No email containing the provided body was found."
        );
    }

    /**
     * Assert that the last email's subject matches the given string.
     *
     * @param string        $subject
     * @param Swift_Message $message
     */
    protected function assertEmailSubject ($subject, Swift_Message $message = null)
    {
        return $this->assertEquals(
            $subject, $this->getEmail($message)->getSubject(),
            "No email with a subject of $subject was found."
        );
    }

    /**
     * Assert that the last email was sent to the given recipient.
     *
     * @param string        $recipient
     * @param Swift_Message $message
     */
    protected function assertEmailTo ($recipient, Swift_Message $message = null)
    {
        return $this->assertArrayHasKey(
            $recipient, (array)$this->getEmail($message)->getTo(),
            "No email was sent to $recipient."
        );
    }

    /**
     * Assert that the last email was delivered by the given address.
     *
     * @param string        $sender
     * @param Swift_Message $message
     */
    protected function assertEmailFrom ($sender, Swift_Message $message = null)
    {
        return $this->assertArrayHasKey(
            $sender, (array)$this->getEmail($message)->getFrom(),
            "No email was sent from $sender."
        );
    }

    /**
     * Store a new swift message.
     *
     * @param Swift_Message $email
     */
    public function addEmail (Swift_Message $email)
    {
        $this->emails[] = $email;
    }

    /**
     * Retrieve the appropriate swift message.
     *
     * @param Swift_Message $message
     */
    protected function getEmail (Swift_Message $message = null)
    {
        $this->assertEmailWasSent();

        return $message ?: $this->lastEmail();
    }

    /**
     * Retrieve the mostly recently sent swift message.
     */
    protected function lastEmail ()
    {
        return end($this->emails);
    }
}

class TestingMailEventListener implements Swift_Events_EventListener
{
    protected $test;

    public function __construct ($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed ($event)
    {
        $this->test->addEmail($event->getMessage());
    }
}