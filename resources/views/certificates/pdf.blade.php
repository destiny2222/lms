<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion - {{ $certificate->certificate_number }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0px;
            padding: 40px;
            background-color: #FFFFFF;
            color: #1F2937;
        }
        .outer-border {
            border: 14px solid #0F172A;
            padding: 30px;
            height: 90%;
            position: relative;
            background: #FAFAFA;
        }
        .inner-border {
            border: 2px dashed #D97706;
            padding: 30px;
            text-align: center;
            height: 88%;
        }
        .header-title {
            font-size: 13px;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: #64748B;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .main-title {
            font-size: 36px;
            color: #0F172A;
            margin: 0;
            font-family: Georgia, serif;
            letter-spacing: 2px;
        }
        .sub-gold {
            color: #D97706;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            margin-top: 5px;
            margin-bottom: 25px;
        }
        .recipient-intro {
            font-size: 14px;
            color: #6B7280;
            margin-bottom: 5px;
        }
        .recipient-name {
            font-size: 34px;
            font-weight: bold;
            color: #1E3A8A;
            text-decoration: underline;
            margin: 10px 0 20px 0;
            font-family: Georgia, serif;
        }
        .cert-desc {
            font-size: 13px;
            line-height: 1.6;
            color: #4B5563;
            max-width: 650px;
            margin: 0 auto 20px auto;
        }
        .course-box {
            font-size: 20px;
            font-weight: bold;
            color: #0F172A;
            background: #F1F5F9;
            padding: 10px 20px;
            display: inline-block;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            margin-bottom: 30px;
        }
        .footer-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        .signature-line {
            border-top: 1px solid #94A3B8;
            padding-top: 6px;
            font-size: 12px;
            color: #334155;
            font-weight: bold;
        }
        .meta-text {
            font-size: 10px;
            color: #94A3B8;
        }
    </style>
</head>
<body>
    <div class="outer-border">
        <div class="inner-border">
            <div class="header-title">AUTHORITY LEARNING & EDUCATION FOUNDATION</div>
            <div class="main-title">CERTIFICATE OF COMPLETION</div>
            <div class="sub-gold">VERIFIED PROFESSIONAL CREDENTIAL</div>

            <div class="recipient-intro">This is to officially certify that</div>
            <div class="recipient-name">{{ $student->name }}</div>

            <div class="cert-desc">
                has successfully fulfilled all course milestones, watched the online video series, passed the progressive knowledge tests, and achieved honors on the final certification exam for:
            </div>

            <div class="course-box">
                {{ $course->title }}
            </div>

            <table class="footer-table">
                <tr>
                    <td style="width: 33%; text-align: left; vertical-align: bottom;">
                        <div style="font-family: 'Brush Script MT', cursive; font-size: 22px; color: #1E3A8A; margin-bottom: 4px;">
                            {{ $course->tutor->name ?? 'Dr. Jane Mitchell' }}
                        </div>
                        <div class="signature-line">Director of Academic Affairs</div>
                        <div class="meta-text">Authority Education Faculty</div>
                    </td>
                    <td style="width: 34%; text-align: center; vertical-align: bottom;">
                        <div style="font-size: 20px; color: #D97706; font-weight: bold; margin-bottom: 5px;">★ OFFICIAL SEAL ★</div>
                        <div class="meta-text">VERIFIED ID: {{ $certificate->certificate_number }}</div>
                    </td>
                    <td style="width: 33%; text-align: right; vertical-align: bottom;">
                        <div style="font-size: 14px; color: #0F172A; font-weight: bold; margin-bottom: 8px;">
                            {{ $certificate->issued_at->format('F d, Y') }}
                        </div>
                        <div class="signature-line">Date of Certification</div>
                        <div class="meta-text">Public Key: {{ substr($certificate->share_token, 0, 12) }}...</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
