<?php

namespace App\Jobs;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Template;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;

class SendTemplateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Group $group, private Template $template, private GroupMember $member)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filename = $this->template->template;
        $subject = "You Have Recieved a Certificate";

        $templatePath = Storage::disk('public')->path($filename);

        $pdf = new Fpdi();
        $groupMemberName = $this->member->name;
        $groupMemberEmail = $this->member->email;
        $pdf->setSourceFile($templatePath);
        $tplId = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($tplId, 0, 0, 1100, 777, true);
        //$ php vendor/tecnickcom/tcpdf/tools/tcpdf_addfont.php -i app/fonts/beinnormal.ttf
        $pdf->SetFont('beinnormal', 'B', 80); // 'B' for bold
        $pdf->SetXY(40, 300); // Set the position where you want to print the name
        $pdf->Cell(0, 0, $groupMemberName, 0, 1, 'C', 0, '', 0);
        $pdfOutput = storage_path(
            'certificates/' . $this->group->id . '-' . $this->member->id . '-' . $this->template->id . '.pdf'
        );
        $pdf->Output($pdfOutput, 'F');
        Mail::send(
            'emails.template',
            ['name' => $groupMemberName, 'description' => $this->template->description],
            function ($message) use ($groupMemberEmail, $groupMemberName, $subject, $pdfOutput) {
                $message->to($groupMemberEmail, $groupMemberName)->subject($subject)->attach($pdfOutput);
            }
        );
    }
}
