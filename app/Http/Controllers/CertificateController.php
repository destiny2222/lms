<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Public verification page with social share buttons & Open Graph meta tags.
     */
    public function verify(string $token): View
    {
        $certificate = Certificate::with(['enrollment.user', 'enrollment.course.tutor'])
            ->where('share_token', $token)
            ->firstOrFail();

        $student = $certificate->enrollment->user;
        $course = $certificate->enrollment->course;

        return view('certificates.verify', compact('certificate', 'student', 'course'));
    }

    /**
     * Download official PDF certificate.
     */
    public function downloadPdf(Certificate $certificate): Response
    {
        $certificate->load(['enrollment.user', 'enrollment.course.tutor']);
        $student = $certificate->enrollment->user;
        $course = $certificate->enrollment->course;

        $pdf = Pdf::loadView('certificates.pdf', compact('certificate', 'student', 'course'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif',
            ]);

        $fileName = 'Certificate-' . $certificate->certificate_number . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Serve or download the vector digital badge.
     */
    public function badge(Certificate $certificate): Response
    {
        $certificate->load(['enrollment.user', 'enrollment.course']);
        $courseTitle = htmlspecialchars($certificate->enrollment->course->title);
        $studentName = htmlspecialchars($certificate->enrollment->user->name);
        $certNo = htmlspecialchars($certificate->certificate_number);

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" width="500" height="500">
  <defs>
    <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#F59E0B"/>
      <stop offset="50%" stop-color="#D97706"/>
      <stop offset="100%" stop-color="#B45309"/>
    </linearGradient>
    <linearGradient id="navyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#1E3A8A"/>
      <stop offset="100%" stop-color="#0F172A"/>
    </linearGradient>
    <filter id="shadow" x="-10%" y="-10%" width="130%" height="130%">
      <feDropShadow dx="0" dy="8" stdDeviation="12" flood-color="#000000" flood-opacity="0.25"/>
    </filter>
  </defs>

  <!-- Outer Star Burst / Medallion -->
  <circle cx="250" cy="250" r="230" fill="url(#navyGrad)" filter="url(#shadow)"/>
  <circle cx="250" cy="250" r="215" fill="none" stroke="url(#goldGrad)" stroke-width="6" stroke-dasharray="8 6"/>
  <circle cx="250" cy="250" r="200" fill="none" stroke="url(#goldGrad)" stroke-width="2"/>

  <!-- Inner Circle -->
  <circle cx="250" cy="250" r="185" fill="#0B132B"/>

  <!-- Trophy / Shield Icon -->
  <g transform="translate(210, 80) scale(1.6)">
    <path fill="url(#goldGrad)" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
  </g>

  <!-- Typography -->
  <text x="250" y="175" font-family="'Helvetica Neue', Arial, sans-serif" font-size="14" font-weight="bold" fill="#F59E0B" text-anchor="middle" letter-spacing="4">OFFICIAL CERTIFIED BADGE</text>
  
  <text x="250" y="225" font-family="'Helvetica Neue', Arial, sans-serif" font-size="20" font-weight="900" fill="#FFFFFF" text-anchor="middle">AUTHORITY LEARNER</text>
  
  <!-- Divider -->
  <line x1="160" y1="245" x2="340" y2="245" stroke="url(#goldGrad)" stroke-width="2"/>
  
  <text x="250" y="280" font-family="'Helvetica Neue', Arial, sans-serif" font-size="15" font-weight="bold" fill="#93C5FD" text-anchor="middle">Awarded To</text>
  <text x="250" y="312" font-family="'Helvetica Neue', Arial, sans-serif" font-size="19" font-weight="bold" fill="#FFFFFF" text-anchor="middle">{$studentName}</text>
  
  <text x="250" y="355" font-family="'Helvetica Neue', Arial, sans-serif" font-size="12" fill="#94A3B8" text-anchor="middle">VERIFIED CERTIFICATE ID</text>
  <text x="250" y="375" font-family="'Courier New', monospace" font-size="13" font-weight="bold" fill="#FBBF24" text-anchor="middle">{$certNo}</text>

  <!-- Bottom Ribbon / Seal -->
  <rect x="150" y="405" width="200" height="32" rx="16" fill="url(#goldGrad)"/>
  <text x="250" y="426" font-family="'Helvetica Neue', Arial, sans-serif" font-size="12" font-weight="bold" fill="#0F172A" text-anchor="middle" letter-spacing="1">AUTHENTICITY VERIFIED</text>
</svg>
SVG;

        return response($svg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'inline; filename="badge-' . $certificate->share_token . '.svg"');
    }
}
