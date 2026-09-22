@extends('front.website.master')

@section('title')
CML Steps
@endsection

@section('content')
<div class="cml-steps" style="padding-top: 100px; padding-bottom: 60px; background-color: #000000; min-height: 100vh;">

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">

        <h3 style="color: #ffffff; font-size: 2.2rem; margin-bottom: 30px; text-align: center; font-weight: 700;
                   border-bottom: 3px solid #4facfe; padding-bottom: 15px;">
            CML Upload Steps
        </h3>

        <div style="background: #0a0a0a; padding: 30px; border-radius: 12px;
                   box-shadow: 0 4px 20px rgba(0,0,0,0.5);
                   border: 1px solid #3a3a3a;">

            <ol style="padding-left: 0; margin: 0; list-style: none;">

                <!-- Step 1 -->
                <li style="margin-bottom: 25px; position: relative; padding-left: 45px;">
                    <span style="position: absolute; left: 0; top: 0;
                               color: #4facfe; font-weight: 600; font-size: 20px;">
                        1.
                    </span>
                    <p style="color: #e0e0e0; font-size: 16px; line-height: 1.7; margin: 0;">
                        Upload your <strong>Client Master List (CML)</strong> document issued by your Depository
                        Participant (DP).
                    </p>
                </li>

                <!-- Step 2 -->
                <li style="margin-bottom: 25px; position: relative; padding-left: 45px;">
                    <span style="position: absolute; left: 0; top: 0;
                               color: #4facfe; font-weight: 600; font-size: 20px;">
                        2.
                    </span>
                    <p style="color: #e0e0e0; font-size: 16px; line-height: 1.7; margin: 0;">
                        Once uploaded, your details will be <strong>automatically extracted</strong> from the CML
                        document.
                    </p>
                </li>

                <!-- Step 3 -->
                <li style="margin-bottom: 25px; position: relative; padding-left: 45px;">
                    <span style="position: absolute; left: 0; top: 0;
                               color: #4facfe; font-weight: 600; font-size: 20px;">
                        3.
                    </span>
                    <p style="color: #e0e0e0; font-size: 16px; line-height: 1.7; margin: 0;">
                        If the CML is <strong>password protected</strong> or data cannot be extracted, you will be
                        prompted to enter the document password.
                    </p>
                </li>

                <!-- Step 4 -->
                <li style="margin-bottom: 25px; position: relative; padding-left: 45px;">
                    <span style="position: absolute; left: 0; top: 0;
                               color: #4facfe; font-weight: 600; font-size: 20px;">
                        4.
                    </span>
                    <p style="color: #e0e0e0; font-size: 16px; line-height: 1.7; margin: 0;">
                        In case automatic extraction still fails, our <strong>verification team</strong> will manually
                        review and verify your CML details.
                    </p>
                </li>

                <!-- Step 5 -->
                <li style="margin-bottom: 0; position: relative; padding-left: 45px;">
                    <span style="position: absolute; left: 0; top: 0;
                               color: #4facfe; font-weight: 600; font-size: 20px;">
                        5.
                    </span>
                    <p style="color: #e0e0e0; font-size: 16px; line-height: 1.7; margin: 0;">
                        Once verified, your Demat details will be securely linked to your account and you can
                        continue using the platform without interruption.
                    </p>
                </li>

            </ol>
        </div>
    </div>
</div>
@endsection