<?php

namespace Autodownload\Mail\Command;

use PhpImap\Mailbox;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadAttachment extends Command
{
    const OPTION_OUTPUT_DIR = 'output';

    /**
     * @var ProgressBar
     */
    protected $progressBar;

    protected function configure()
    {
        $this->setName('download');
        $this->addOption(self::OPTION_OUTPUT_DIR, '-o', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $targetDir = $input->getOption(self::OPTION_OUTPUT_DIR);
        if (!$targetDir) {
            $targetDir = sys_get_temp_dir();
        }

        $mailbox = new Mailbox('{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX', 'testxyz@gmail.com',
            'your_password',
            sys_get_temp_dir());

        // Search Mails from Mailbox
        $mailIds = $mailbox->searchMailbox('ALL');
        if(!$mailIds) {
            die('Mailbox is empty');
        }

//      $mailboxInfo = $mailbox->getListingFolders('*');
//      var_dump($mailboxInfo);
        
// 	Info about used Mailbox
// 	$mailboxInfo = $mailbox->getMailboxInfo();
// 	var_dump($mailboxInfo);

        $this->progressBar = new ProgressBar($output, count($mailIds));
        $this->progressBar->setFormat('very_verbose');
        $this->progressBar->setRedrawFrequency(1);

        foreach ($mailIds as $id) {

            $mail = $mailbox->getMail($id, false);

            $billingDate = new \DateTime($mail->date);

            // exlude domain from email-address for the right "mkdir" folder-structure on NAS Storage
            $email = $mail->fromAddress;
            $email = explode('@', $email)[1];
            $email = explode('.', $email);
            array_pop($email);
            $domain = array_pop($email);

            if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                $output->writeln('Mail: <info>#' . $mail->id . '</info> received: <info>' . $mail->date . '</info> "' . $mail->fromAddress . '"'. ' domain: <info>'. $domain .'</info>');
            }
       
            // exclude attachment to NAS-storage
	    $finished = true;
            foreach ($mail->getAttachments() as $attachment) {
                $search = array(' ', ':');
                $targetFilename = str_replace($search, '-', $mail->date) . '-' . str_replace('/', '-', $attachment->name);
                $monthDir = $targetDir . '/' . $billingDate->format('Y') . '/' . $domain . '/' . $billingDate->format('m') .'/';
                if (!is_dir($monthDir)) {
                    mkdir($monthDir, 0775, true);
                }
                if ($attachment->name == 'admin-test.pdf') {
                 $ok = rename($attachment->filePath, $targetDir . '/' . $attachment->name);
                }
	        else {
                 $ok = rename($attachment->filePath, $monthDir . $targetFilename);
		}
	    if (isset($ok) && $ok==false) { $finished == false; }
            }

	    if (isset($finished) && $finished == false) {
		$to = "alertmail@youre_domain.de";
	    	$subject = "Automatic alert eMail because the automated attachment downloader was failed!";
		$txt = "Automatic alert eMail because the automated attachment downloader was failed: $mail->fromAddress";
		$headers = "From: root@localsystem.local" . "\r\n"; // . "CC: in-CC-@your_domain.de";
		mail($to,$subject,$txt,$headers);
	    }
	    else {
		$mailbox->moveMail($id, 'successfully_exported');
	    }

            $this->updateProgress($output);
	    
        }
	
    }

    /**
     * @param OutputInterface $output
     */
    protected function updateProgress(OutputInterface $output)
    {
        if ($output->getVerbosity() === OutputInterface::VERBOSITY_NORMAL) {
            $this->progressBar->advance(1);
        }
    }

}
