<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Securities Purchase/Transfer Letter - Transaction #{{ $transaction->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            color: #000;
            background: #fff;
            font-size: 12px;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-decoration: underline;
        }

        .date-execution {
            text-align: right;
            margin-bottom: 30px;
            font-size: 14px;
            font-weight: bold;
        }

        .recipient-info {
            margin-bottom: 30px;
        }

        .subject {
            margin-bottom: 30px;
            font-weight: bold;
        }

        .company-details {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #000;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin: 30px 0 15px 0;
            text-align: center;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border: 2px solid #000;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
            vertical-align: top;
        }

        .details-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .details-table td:first-child {
            text-align: center;
            font-weight: bold;
            width: 15%;
        }

        .details-table td:nth-child(2) {
            width: 50%;
            font-weight: bold;
        }

        .details-table td:last-child {
            width: 35%;
        }

        .bank-details-header {
            background-color: #e0e0e0 !important;
            text-align: center;
            font-weight: bold;
        }

        .disclaimer {
            margin-top: 40px;
            text-align: justify;
            font-size: 11px;
            line-height: 1.4;
        }

        .disclaimer p {
            margin-bottom: 15px;
        }

        .amount-words {
            font-style: italic;
            color: #666;
        }

        /* @page {
            size: A4;
            margin: 20mm;
        } */

        @media print {
            body {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>SECURITIES PURCHASE/TRANSFER LETTER</h1>
    </div>

    <div class="date-execution">
        <blockquote>Date of execution: {{ $transaction->created_at->format('jS F, Y') }}</blockquote>
    </div>

    <div class="recipient-info">
        <p>To,</p>
        <p style="font-weight: bold; font-size: 14px; margin-top: 10px;">
            <strong>{{ $investor->name ?? 'N/A' }}</strong>
        </p>
    </div>

    <div class="subject">
        <p><strong>Subject:</strong> Deal Letter of <strong>{{ $company->brand_name ?? $company->name ?? 'N/A'
                }}</strong>
            {{ ucfirst($transaction->instrument) }} As per telephonic discussion, we confirm our trade as follows</p>
    </div>

    <div class="company-details">
        @if($company && $company->cin)
        <p><strong>CIN:</strong> {{ $company->cin }}</p>
        @endif
        <p><strong>Name of the company (in full):</strong> <strong>{{ strtoupper($company->company_name ??
                $company->brand_name
                ?? 'N/A') }}</strong></p>
        <p><strong>Name of the Stock Exchange where the company is listed, if any:</strong> <strong>{{
                'NA' }}</strong></p>
    </div>

    <h2 class="section-title">DESCRIPTION OF SECURITIES:</h2>

    <table class="details-table">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Particulars</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.</td>
                <td>Kind/ Class of securities</td>
                <td>{{ ucfirst($transaction->instrument) }}</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Nominal value of each unit of security</td>
                <td>Amount in Rs. {{ number_format($company->fundamentals->face_value ?? 1, 1) }}/-</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Premium per share</td>
                <td>Amount in Rs. {{ number_format($transaction->share_price - ($company->fundamentals->face_value ??
                    1), 0) }}/-</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Total Amount to be paid per unit of security</td>
                <td>Amount in Rs. {{ number_format($transaction->share_price, 0) }}/-</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>No. of securities being purchased/transferred</td>
                <td>{{ number_format($transaction->shares) }} {{ strtolower($transaction->instrument) }} shares</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Total Investment</td>
                <td>Amount in Rs. {{ number_format($transaction->investment_amount, 0) }}/-</td>
            </tr>
        </tbody>
    </table>

    @if($seller)
    <h2 class="section-title">SELLER/TRANSFEROR'S PARTICULARS:</h2>

    <table class="details-table">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Particulars</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @if($seller->cin)
            <tr>
                <td>1.</td>
                <td>CIN</td>
                <td>{{ $seller->cin }}</td>
            </tr>
            @endif
            @if($seller->pan)
            <tr>
                <td>{{ $seller->cin ? '2' : '1' }}.</td>
                <td>PAN</td>
                <td>{{ $seller->pan }}</td>
            </tr>
            @endif
            <tr>
                <td>{{ ($seller->cin && $seller->pan) ? '3' : ($seller->cin || $seller->pan ? '2' : '1') }}.
                </td>
                <td>Name of the Company/Individual</td>
                <td>{{ strtoupper($seller->company_name) }}</td>
            </tr>
            @if($seller->address)
            <tr>
                <td>{{ ($seller->cin && $seller->pan) ? '4' : '3' }}.</td>
                <td>Address:</td>
                <td>{{ $seller->address }}</td>
            </tr>
            @endif
            @if($seller->dp_id)
            <tr>
                <td>5.</td>
                <td>DP ID:</td>
                <td>{{ $seller->dp_id }}</td>
            </tr>
            @endif
            @if($seller->client_id)
            <tr>
                <td>6.</td>
                <td>Client ID:</td>
                <td>{{ $seller->client_id }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="3" class="bank-details-header">Bank Account Details</td>
            </tr>
            @if($seller->bank_name)
            <tr>
                <td>7.</td>
                <td>Bank Name</td>
                <td>{{ strtoupper($seller->bank_name) }}</td>
            </tr>
            @endif
            @if($seller->account_number)
            <tr>
                <td>8.</td>
                <td>Account Number</td>
                <td>{{ $seller->account_number }}</td>
            </tr>
            @endif
            @if($seller->ifsc)
            <tr>
                <td>9.</td>
                <td>IFSC:</td>
                <td>{{ strtoupper($seller->ifsc) }}</td>
            </tr>
            @endif
            @if($seller->branch)
            <tr>
                <td>10.</td>
                <td>Branch:</td>
                <td>{{ $seller->branch }}</td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif

    <h2 class="section-title">PURCHASER/TRANSFEREE'S PARTICULARS:</h2>

    <table class="details-table">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Particulars</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.</td>
                <td>CIN in case of Company</td>
                <td>{{ $investor->cin ?? 'NA' }}</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>PAN</td>
                <td>{{ $investor->newPan->pan_no ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Name of the Individual/ Company/entity</td>
                <td>{{ $investor->name ?? 'N/A' }}</td>
            </tr>
            @if($investor->father_name)
            <tr>
                <td>4.</td>
                <td>Father's/ Mother's/ Spouse name</td>
                <td>{{ strtoupper($investor->father_name) }}</td>
            </tr>
            @endif
            <tr>
                <td>5.</td>
                <td>E-mail id</td>
                <td>{{ strtoupper($investor->email ?? 'N/A') }}</td>
            </tr>
            @if($investor->address)
            <tr>
                <td>6.</td>
                <td>Address:</td>
                <td>{{ $investor->address }}</td>
            </tr>
            @endif
            @if($investor->demat_account)
            <tr>
                <td>7.</td>
                <td>Demat Account Number:</td>
                <td><em>{{ $investor->demat_account }}</em></td>
            </tr>
            @endif
            @if($investor->dp_id)
            <tr>
                <td>8.</td>
                <td>DP ID:</td>
                <td>{{ $investor->dp_id }}</td>
            </tr>
            @endif
            @if($investor->client_id)
            <tr>
                <td>9.</td>
                <td>Client ID:</td>
                <td>{{ $investor->client_id }}</td>
            </tr>
            @endif
            {{-- <tr>
                <td colspan="3" class="bank-details-header">Bank Account Details</td>
            </tr> --}}
            @if($investor->bank_name)
            <tr>
                <td>10.</td>
                <td>Bank Name</td>
                <td>{{ strtoupper($investor->bank_name) }}</td>
            </tr>
            @endif
            @if($investor->account_number)
            <tr>
                <td>11.</td>
                <td>Account Number</td>
                <td>{{ $investor->account_number }}</td>
            </tr>
            @endif
            @if($investor->ifsc_code)
            <tr>
                <td>12.</td>
                <td>IFSC:</td>
                <td>{{ strtoupper($investor->ifsc_code) }}</td>
            </tr>
            @endif
            @if($investor->branch_name)
            <tr>
                <td>13.</td>
                <td>Branch:</td>
                <td>{{ $investor->branch_name }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="disclaimer">
        <p><strong>Disclaimer:</strong> Buyer has to transfer the amount in the above-mentioned account. In accordance
            with the deal mandate for transferring shares, Buyer is required to furnish the following details: Name,
            Address, PAN Card, Client Master List copy (CML), Bank Account Details, and UTR number. We will ensure the
            smooth transfer of the agreed number of shares into your DEMAT account as per your Client Master List.
            Please note that third-party transactions are strictly prohibited.</p>

        <p>Furthermore, Buyer confirms that if buyer is a Non-Resident Indian or an entity registered outside India, the
            transaction value shall be transferred to us through a Non-Resident Ordinary (NRO) Account exclusively.
            Funds transferred through a Non-Residential External Account (NRE) shall not be permissible, and we shall
            not be liable for any damages, losses, or costs incurred due to such transfers. Buyer and its
            representatives agree that the shares are provided/arranged on a private placement basis.</p>

        <p>In the event Seller or its representative is unable to Complete the transaction or not able to source shares
            because of any reason, seller will return the transaction amount to your bank account without imposing any
            penalty on seller or its representatives or any platform. Seller holds no responsibility for price
            volatility and are not obligated to assist you in selling or repurchasing shares. In circumstances of high
            volatility or inventory unavailability because of any reason, we reserve the right to cancel the deal and
            refund the consideration amount to you without any penalty or liability. On the other hand, buyer is
            obligated to honour and pay the agreed amount irrespective of any circumstances; force majeure clauses shall
            not apply to buyer in this regard.</p>

        <p>Upon providing us with the mandate and transferring the full or partial amount, you are obligated to complete
            the transaction. Failure to transfer pending amounts within the stipulated timeframe will result in
            forfeiture of the principal amount. Additionally, you will be liable to pay the pending amount within two
            working days from the time inventory is sourced. Failure to comply will result in an 18% per annum interest
            charge for the subsequent 15 days, after which all legal expenses related to recovery will be borne by you.
        </p>

        <p>This letter is deemed valid only if partial or full payments are received on the same day. If the transaction
            proceeds at your request, funds must be transferred, and the transaction must be completed in accordance
            with the above and below mentioned Terms.</p>

        <p>Buyer and its representatives acknowledge that we are neither a stock exchange nor an advisory platform. This
            deal is shared upon your request following discussions and your keen interest. You affirm that the deal is
            conducted on a private placement basis after understanding and analysing all risks involved.</p>

        <p>Buyer its representatives confirm that this is not an advertisement, solicitation, or offer to buy or sell
            any financial instruments or to participate in any trading strategy. No offers, invitations, solicitations,
            advice, representations, warranties, or recommendations (verbal or written) have been provided by us or our
            representatives directly or indirectly. Any research report provided by seller or its representatives is at
            buyers or its representatives request, and buyer should conduct their own due diligence. Seller or its
            representatives or any platform bear no responsibility for any resulting profit, loss, or capital erosion,
            and buyer and its representatives indemnify seller or its representatives against any liabilities arising
            from this purchase/transaction.</p>

        <p>Buyer its representatives are aware that investments in private markets/unlisted shares are suitable only for
            Accredited/High Net Worth Investors (HNIs) who can bear high risks according to their net worth and profile.
            Buyer is also aware that investment in unlisted share should be for tenure of minimum 10 years. Before
            investing, you have thoroughly understood the security type, transaction nature, issuer details, and all
            other relevant information necessary for informed decision-making.</p>

        <p>Buyer its representatives confirm that Seller or its representatives have not promised guaranteed returns or
            capital protection by seller or his representative. Any representations regarding financial figures or IPO
            dates are subject to change, and you must exercise due diligence before relying on such information. You
            assume all risks and liabilities associated with the investment.</p>

        <p>Additionally, Buyer and its representatives understand that there is no assurance of exit or listing, and
            there may be situations where the IPO price is lower than the purchase price. Unlisted shares are subject to
            a lock-in period of six months from the IPO allotment date. You acknowledge that we act as a seller or
            source to get this private placement deal and are not responsible for facilitating sales or exits at any
            time.</p>

        <p>You also agree to ensure the receipt of shares within 48 hours of the transaction. Failure to do so will not
            hold us responsible for any claims, including non-receipt of shares, in the future. We retain the discretion
            to refund the money or transfer the shares as deemed appropriate.</p>

        <p>Buyer its representatives agree to indemnify, defend, and hold Seller or its representatives harmless against
            any losses, claims, judgments, fines, penalties, damages, or liabilities arising from this sale/transaction.
        </p>

        <p>Upon acceptance of this deal letter or partial/full money transfer, Buyer or its representatives acknowledge
            and agree to all the terms and conditions outlined herein and indemnify seller or its representative or any
            platform for any future claims or losses.</p>

        @if($transaction->notes)
        <p><strong>Additional Notes:</strong> {{ $transaction->notes }}</p>
        @endif
    </div>
</body>

</html>