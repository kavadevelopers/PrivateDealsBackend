<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    <div class="d-flex flex-column gap-5">
        <div class="card card-flush">
            <div class="card-header">
                <div class="card-title">
                    <h2>AI Guide — Company Ingest</h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.ai-autowork.company-ingest.inbox') }}" class="btn btn-sm btn-light">Inbox</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <p class="text-muted mb-6">
                    Build a prompt with company page URLs, then copy and paste it to your AI agent.
                    The prompt uses secret <code>SHURUUP_API_TOKEN</code> (not the raw key).
                </p>

                <div class="mb-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label required mb-0">Company page URL(s)</label>
                        <button type="button" class="btn btn-sm btn-light-primary" id="btn_add_url_row">+ Add URL</button>
                    </div>
                    <div id="company_url_rows" class="d-flex flex-column gap-3"></div>
                    <div class="text-danger fs-7 mt-2 d-none" id="url_validation_msg">
                        Add at least one valid company page URL before copying.
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label">Extra instructions for AI (optional)</label>
                    <textarea id="extra_instructions" class="form-control" rows="3"
                        placeholder="e.g. Prefer CIN from MCA. Focus on fundamentals and promoters."></textarea>
                </div>

                <div class="d-flex flex-wrap gap-3 mb-5">
                    <button type="button" class="btn btn-primary" id="btn_copy_prompt">Copy prompt for AI</button>
                    <button type="button" class="btn btn-light" id="btn_refresh_preview">Refresh preview</button>
                    <span class="text-success align-self-center d-none" id="copy_success">Copied</span>
                </div>

                <label class="form-label">Prompt preview (what gets copied)</label>
                <textarea id="prompt_preview" class="form-control font-monospace" rows="24" readonly></textarea>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            (function() {
                const schemaUrl = @json($schemaUrl);
                const companiesUrl = @json($companiesUrl);
                const apiBase = @json($apiBase);
                const rowsEl = document.getElementById('company_url_rows');
                const previewEl = document.getElementById('prompt_preview');
                const extraEl = document.getElementById('extra_instructions');
                const validationEl = document.getElementById('url_validation_msg');
                const copySuccessEl = document.getElementById('copy_success');

                function addUrlRow(value = '') {
                    const wrap = document.createElement('div');
                    wrap.className = 'input-group company-url-row';
                    wrap.innerHTML =
                        '<input type="url" class="form-control company-url-input" placeholder="https://example.com/company-page" value="' +
                        (value || '').replace(/"/g, '&quot;') + '">' +
                        '<button type="button" class="btn btn-light-danger btn-remove-url">Remove</button>';
                    rowsEl.appendChild(wrap);
                    wrap.querySelector('.btn-remove-url').addEventListener('click', function() {
                        if (rowsEl.querySelectorAll('.company-url-row').length <= 1) {
                            wrap.querySelector('.company-url-input').value = '';
                            refreshPreview();
                            return;
                        }
                        wrap.remove();
                        refreshPreview();
                    });
                    wrap.querySelector('.company-url-input').addEventListener('input', refreshPreview);
                }

                function getUrls() {
                    return Array.from(document.querySelectorAll('.company-url-input'))
                        .map(function(input) { return (input.value || '').trim(); })
                        .filter(Boolean);
                }

                function isValidHttpUrl(str) {
                    try {
                        const u = new URL(str);
                        return u.protocol === 'http:' || u.protocol === 'https:';
                    } catch (e) {
                        return false;
                    }
                }

                function getValidUrls() {
                    return getUrls().filter(isValidHttpUrl);
                }

                function buildPrompt() {
                    const urls = getValidUrls();
                    const extra = (extraEl.value || '').trim();

                    let prompt = '';
                    prompt += 'You are an autonomous data agent for PrivateDeals AI AutoWork — Company Ingest.\n';
                    prompt += 'Research each company URL fully, extract accurate values, and POST JSON to our ingest API.\n\n';

                    prompt += '=== AUTH (IMPORTANT) ===\n';
                    prompt += 'Use the secret named SHURUUP_API_TOKEN from your environment / OpenClaw secrets.\n';
                    prompt += 'Do NOT invent a token. Do NOT ask the user to paste a raw key into chat.\n';
                    prompt += 'On every request send header:\n';
                    prompt += 'X-AUTH-TOKEN: <value of secret SHURUUP_API_TOKEN>\n';
                    prompt += 'Content-Type: application/json\n\n';

                    prompt += '=== API BASE ===\n';
                    prompt += apiBase + '\n\n';

                    prompt += '=== STEPS ===\n';
                    prompt += '1) GET ' + schemaUrl + ' (with X-AUTH-TOKEN). Read sections + example_body from the JSON response — that is the payload contract. Do not invent a different shape.\n';
                    prompt += '2) Open each company URL and extract data using the READING RULES below.\n';
                    prompt += '3) POST ' + companiesUrl + ' using the example_body shape from schema (fill with real values).\n';
                    prompt += '4) Optional PATCH ' + companiesUrl + '/{uuid} to merge more sections.\n';
                    prompt += '5) Optional GET ' + companiesUrl + '/{uuid} for status.\n\n';

                    prompt += '=== READING RULES (MUST FOLLOW) ===\n';
                    prompt += 'Do not skim. Open the full company page and every related section/tab.\n\n';

                    prompt += 'ABOUT THE COMPANY:\n';
                    prompt += '- Find the About / Overview / Company profile section and copy the COMPLETE text into company.about.\n';
                    prompt += '- Do not truncate to one paragraph. Include business description, products/services, history, and highlights shown on the page.\n';
                    prompt += '- Also capture brand name, legal company name, CIN, sector, logo URL, keywords/aliases.\n\n';

                    prompt += 'DRHP FILED:\n';
                    prompt += '- Look for badge/tag/chip text like "DRHP Filed", "DRHP", or similar near the company header.\n';
                    prompt += '- If present, set company.is_drhp = true (also acceptable: company.drhp_filed / tags including DRHP).\n';
                    prompt += '- If not present, set company.is_drhp = false.\n\n';

                    prompt += 'LOGO:\n';
                    prompt += '- Capture the company logo image as an absolute https URL in company.logo_url (header logo / og:image / brand image).\n';
                    prompt += '- Prefer a direct image URL ending in png/jpg/webp/svg when available.\n\n';

                    prompt += 'LEADERSHIP / MANAGEMENT (= promoters):\n';
                    prompt += '- On the page this is often labeled "Leadership", "Management", or "Promoters".\n';
                    prompt += '- Extract EVERY person shown (if 3 people are visible, send 3 promoters — never drop one).\n';
                    prompt += '- For each person capture: name, designation/role, experience (years/bio text shown — do not leave blank if visible), and LinkedIn/profile URL in "url" when a link exists.\n';
                    prompt += '- LinkedIn icons/links must be saved in promoters[].url.\n\n';

                    prompt += 'SHAREHOLDERS (MULTI-TAB):\n';
                    prompt += '- Shareholders often use year tabs (FY23, FY24, etc.). You MUST open and extract ALL tabs, not only the default one.\n';
                    prompt += '- Prefer year-keyed object like schema.example_body.shareholders: { "FY24": [{"name":"...","percentage":55.5}], "FY23": [...] }.\n';
                    prompt += '- Flat format with percentages[] is also accepted.\n\n';

                    prompt += 'FINANCIALS (MULTI-TAB):\n';
                    prompt += '- Open ALL tabs: Income/P&L (pl_statement), Balance Sheet (balance_sheet), Cash Flow (cashflow), Financial Ratios (financial_ratios).\n';
                    prompt += '- Prefer year-keyed values like schema.example_body (FY23/FY24 → metrics). Table matrix is also accepted.\n\n';

                    prompt += 'EVENTS:\n';
                    prompt += '- Extract events with title, description, date, and file/attachment URL when present.\n';
                    prompt += '- If there are more than 5 events, send ONLY the latest 5 by date (newest first).\n\n';

                    prompt += 'FUNDAMENTALS:\n';
                    prompt += '- Fundamentals identifiers and ratios when shown.\n\n';

                    prompt += '=== PAYLOAD CONTRACT ===\n';
                    prompt += 'Do NOT use a hardcoded example from this prompt.\n';
                    prompt += 'Always follow GET schema → example_body + sections + not_accepted + events_limit.\n';
                    prompt += 'Required: cin OR (brand_name AND company_name). company.type: unlisted | secondary.\n';
                    prompt += 'Do NOT send keys listed in schema.not_accepted.\n\n';

                    prompt += '=== RULES ===\n';
                    prompt += '- Only call /api/sandbox/ai/* with SHURUUP_API_TOKEN.\n';
                    prompt += '- Prefer facts from the provided URLs; omit unknown critical IDs rather than guessing.\n';
                    prompt += '- Same CIN on a pending ingest upserts the same record (see schema.upsert).\n';
                    prompt += '- Events: max 5 latest (schema.events_limit).\n\n';

                    prompt += '=== COMPANY PAGE URLS TO RESEARCH ===\n';
                    if (urls.length === 0) {
                        prompt += '(none added yet)\n';
                    } else {
                        urls.forEach(function(u, i) {
                            prompt += (i + 1) + '. ' + u + '\n';
                        });
                    }

                    if (extra) {
                        prompt += '\n=== EXTRA INSTRUCTIONS ===\n' + extra + '\n';
                    }

                    prompt += '\nAfter each ingest, summarize uuid, cin/brand_name, is_drhp, logo_url present, promoters count (with LinkedIn urls), shareholder year-tabs extracted, events count (max 5), financial tabs extracted, and accepted_keys/ignored_keys.\n';
                    return prompt;
                }

                function refreshPreview() {
                    previewEl.value = buildPrompt();
                    const valid = getValidUrls();
                    const hasAnyInput = getUrls().length > 0;
                    if (hasAnyInput && valid.length === 0) {
                        validationEl.classList.remove('d-none');
                        validationEl.textContent = 'Each URL must be a valid http(s) link.';
                    } else if (valid.length === 0) {
                        validationEl.classList.remove('d-none');
                        validationEl.textContent = 'Add at least one valid company page URL before copying.';
                    } else {
                        validationEl.classList.add('d-none');
                    }
                }

                function flashCopied() {
                    copySuccessEl.classList.remove('d-none');
                    setTimeout(function() { copySuccessEl.classList.add('d-none'); }, 2000);
                }

                async function copyText(text) {
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        await navigator.clipboard.writeText(text);
                        return;
                    }
                    previewEl.focus();
                    previewEl.select();
                    document.execCommand('copy');
                }

                document.getElementById('btn_add_url_row').addEventListener('click', function() { addUrlRow(); });
                document.getElementById('btn_refresh_preview').addEventListener('click', refreshPreview);
                extraEl.addEventListener('input', refreshPreview);

                document.getElementById('btn_copy_prompt').addEventListener('click', async function() {
                    const valid = getValidUrls();
                    if (valid.length === 0) {
                        validationEl.classList.remove('d-none');
                        const hasAnyInput = getUrls().length > 0;
                        const message = hasAnyInput
                            ? 'Each company page URL must be a valid http(s) link before you can copy the prompt.'
                            : 'Please add at least one company page URL before copying the prompt for AI.';
                        validationEl.textContent = message;
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({ icon: 'warning', title: 'Company URL required', text: message, confirmButtonText: 'OK' });
                        } else {
                            alert(message);
                        }
                        const firstInput = document.querySelector('.company-url-input');
                        if (firstInput) firstInput.focus();
                        return;
                    }
                    refreshPreview();
                    try {
                        await copyText(previewEl.value);
                        flashCopied();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Copied',
                                text: 'Prompt copied. Ensure OpenClaw has secret SHURUUP_API_TOKEN set.',
                                timer: 2200,
                                showConfirmButton: false
                            });
                        }
                    } catch (e) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error', 'Could not copy prompt', 'error');
                        } else {
                            alert('Could not copy prompt');
                        }
                    }
                });

                addUrlRow();
                refreshPreview();
            })();
        </script>
    @endpush
</x-default-layout>
