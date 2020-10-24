<?php

namespace App\Command;

use App\Enum\StatusEnumType;
use App\Repository\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailNotifProductInPendingMoreThanAWeekCommand extends Command
{
    protected static $defaultName = 'app:email-notif-product-in-pending-more-than-a-week';

    protected $productRepository;

    protected $mailer;

    public function __construct(ProductRepository $productRepository, MailerInterface $mailer)
    {
        parent::__construct();

        $this->productRepository = $productRepository;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this->setDescription('Look for products on “pending” for a week or more and send some sort of notification');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $products = $this->productRepository->findByStatusAndCreatedAtLessThan(StatusEnumType::PENDING_STATUS, new \Datetime('-7 days'));

        $email = new TemplatedEmail();

        $email->to('superman@gmail.com');
        $email->from('lois@gmail.com');
        $email->subject('Products on "pending" for a week or more');
        $email->htmlTemplate('product_pending_7days.txt.twig');
        $email->context(['products' => $products]);

        $this->mailer->send($email);

        $io->success('Proudcts count:' . count($products));

        return 0;
    }
}
