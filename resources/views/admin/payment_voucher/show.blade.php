<x-admin.app>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="mdi mdi-receipt mr-2 text-primary"></i>{{ __('Détails du bon de paiement') }}
                        </h4>
                        <p class="text-muted mb-0">{{ __('Numéro de bon') }}: <strong>{{ $voucher->getVoucherNumber() }}</strong></p>
                    </div>
                    <div>
                        <a href="{{ route('admin.payment_voucher.edit', $voucher->getId()) }}" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-pencil mr-2"></i>{{ __('Modifier') }}
                        </a>
                        <a href="{{ route('admin.payment_voucher.index') }}" class="btn btn-outline-secondary ml-2">
                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Details -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="mdi mdi-information-outline mr-2"></i>{{ __('Informations du bon') }}
                        </h4>

                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-semibold" style="width: 40%;">{{ __('Numéro de bon') }}:</td>
                                        <td><strong class="text-primary">{{ $voucher->getVoucherNumber() }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Numéro de facture') }}:</td>
                                        <td>{{ $voucher->getInvoiceNumber() ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Date de facture') }}:</td>
                                        <td>{{ \Carbon\Carbon::parse($voucher->getInvoiceDate())->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Montant') }}:</td>
                                        <td>
                                            <strong class="text-success" style="font-size: 1.2em;">
                                                {{ number_format($voucher->getAmount(), 2, ',', ' ') }} {{ __('DH') }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Catégorie') }}:</td>
                                        <td>
                                            <span class="badge badge-info badge-lg">
                                                @php
                                                    $categories = [
                                                        'carburant' => __('Bon pour Carburant'),
                                                        'entretien' => __('Entretien'),
                                                        'lavage' => __('Lavage'),
                                                        'lubrifiant' => __('Lubrifiant'),
                                                        'reparation' => __('Reparation'),
                                                        'achat_pieces_recharges' => __('Achat pieces de recharges'),
                                                        'rechange_pneu' => __('Rechange pneu'),
                                                        'frais_immatriculation' => __('Frais d\'immatriculation'),
                                                        'visite_technique' => __('Visite technique'),
                                                    ];
                                                @endphp
                                                {{ $categories[$voucher->getCategory()] ?? $voucher->getCategory() }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Véhicule concerné') }}:</td>
                                        <td>
                                            @if($voucher->vehicule)
                                                <strong>{{ $voucher->vehicule->getBrand() }} - {{ $voucher->vehicule->getModel() }}</strong>
                                                <br>
                                                <small class="text-muted">{{ __('Matricule') }}: {{ $voucher->vehicule->getMatricule() }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('KM du véhicule') }}:</td>
                                        <td>{{ number_format($voucher->getVehicleKm(), 0, ',', ' ') }} {{ __('KM') }}</td>
                                    </tr>
                                    @if($voucher->getVehicleHours())
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Heures du véhicule') }}:</td>
                                        <td>{{ number_format($voucher->getVehicleHours(), 0, ',', ' ') }} {{ __('H') }}</td>
                                    </tr>
                                    @endif
                                    @if($voucher->getInsuranceExpirationDate())
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Date d\'expiration de l\'assurance') }}:</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($voucher->getInsuranceExpirationDate())->format('d/m/Y') }}
                                            @php
                                                $daysUntilExpiry = \Carbon\Carbon::parse($voucher->getInsuranceExpirationDate())->diffInDays(\Carbon\Carbon::now(), false);
                                            @endphp
                                            @if($daysUntilExpiry < 0)
                                                <span class="badge badge-danger ml-2">{{ __('Expirée') }}</span>
                                            @elseif($daysUntilExpiry <= 30)
                                                <span class="badge badge-warning ml-2">{{ __('Expire dans') }} {{ abs($daysUntilExpiry) }} {{ __('jours') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($voucher->getCategory() === 'carburant' && $voucher->getFuelLiters())
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Litres de carburant') }}:</td>
                                        <td>
                                            <strong>{{ number_format($voucher->getFuelLiters(), 2, ',', ' ') }} L</strong>
                                            @php
                                                $consumption = $voucher->getAmount() / $voucher->getFuelLiters();
                                            @endphp
                                            <br>
                                            <small class="text-muted">{{ __('Prix par litre') }}: {{ number_format($consumption, 2, ',', ' ') }} {{ __('DH/L') }}</small>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($voucher->getCategory() === 'rechange_pneu' && $voucher->tire)
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Pneu changé') }}:</td>
                                        <td>
                                            <strong>{{ $voucher->tire->getTirePosition() }}</strong>
                                            <br>
                                            <small class="text-muted">{{ __('Seuil') }}: {{ number_format($voucher->tire->getThresholdKm(), 0, ',', ' ') }} {{ __('KM') }}</small>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($voucher->getCategory() === 'entretien')
                                        @if($voucher->vidange)
                                        <tr>
                                            <td class="font-weight-semibold">{{ __('Vidange') }}:</td>
                                            <td>
                                                <span class="badge badge-success">{{ __('Effectuée') }}</span>
                                                <br>
                                                <small class="text-muted">{{ __('Seuil') }}: {{ number_format($voucher->vidange->getThresholdKm(), 0, ',', ' ') }} {{ __('KM') }}</small>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($voucher->timingChaine)
                                        <tr>
                                            <td class="font-weight-semibold">{{ __('Chaîne de distribution') }}:</td>
                                            <td>
                                                <span class="badge badge-success">{{ __('Changée') }}</span>
                                                <br>
                                                <small class="text-muted">{{ __('Seuil') }}: {{ number_format($voucher->timingChaine->getThresholdKm(), 0, ',', ' ') }} {{ __('KM') }}</small>
                                            </td>
                                        </tr>
                                        @endif
                                    @endif
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Fournisseur') }}:</td>
                                        <td>{{ $voucher->getSupplier() ?? '-' }}</td>
                                    </tr>
                                    @if($voucher->getAdditionalInfo())
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Informations supplémentaires') }}:</td>
                                        <td>{{ $voucher->getAdditionalInfo() }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Créé le') }}:</td>
                                        <td>{{ $voucher->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">{{ __('Modifié le') }}:</td>
                                        <td>{{ $voucher->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Document Preview -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="mdi mdi-file-document-outline mr-2"></i>{{ __('Document') }}
                        </h4>

                        @if($voucher->getDocumentPath())
                            @php
                                $fileExtension = strtolower(pathinfo($voucher->getDocumentPath(), PATHINFO_EXTENSION));
                                $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $isPdf = $fileExtension === 'pdf';
                            @endphp

                            <div class="text-center mb-3">
                                @if($isImage)
                                    <img src="{{ asset($voucher->getDocumentPath()) }}" 
                                         alt="{{ __('Document') }}" 
                                         class="img-fluid rounded shadow-sm" 
                                         style="max-height: 400px; cursor: pointer;"
                                         onclick="openDocumentModal('{{ asset($voucher->getDocumentPath()) }}', 'image')">
                                @elseif($isPdf)
                                    <div class="border rounded p-4 bg-light">
                                        <i class="mdi mdi-file-pdf-box" style="font-size: 5rem; color: #dc3545;"></i>
                                        <p class="mt-2 mb-0">{{ __('Document PDF') }}</p>
                                    </div>
                                @else
                                    <div class="border rounded p-4 bg-light">
                                        <i class="mdi mdi-file-document" style="font-size: 5rem; color: #6c757d;"></i>
                                        <p class="mt-2 mb-0">{{ __('Document') }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ asset($voucher->getDocumentPath()) }}" 
                                   target="_blank" 
                                   class="btn btn-primary btn-block waves-effect waves-light">
                                    <i class="mdi mdi-eye mr-2"></i>{{ __('Voir en plein écran') }}
                                </a>
                                <a href="{{ asset($voucher->getDocumentPath()) }}" 
                                   download 
                                   class="btn btn-outline-secondary waves-effect waves-light">
                                    <i class="mdi mdi-download"></i>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="mdi mdi-file-document-outline" style="font-size: 4rem; color: #dee2e6;"></i>
                                <p class="text-muted mt-3 mb-0">{{ __('Aucun document disponible') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Modal -->
    <div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentModalLabel">{{ __('Aperçu du document') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalDocumentImage" src="" alt="{{ __('Document') }}" class="img-fluid" style="max-height: 70vh;">
                    <iframe id="modalDocumentPdf" src="" style="width: 100%; height: 70vh; display: none;" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <a id="modalDocumentDownload" href="" download class="btn btn-primary">
                        <i class="mdi mdi-download mr-2"></i>{{ __('Télécharger') }}
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Fermer') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDocumentModal(url, type) {
            const modal = $('#documentModal');
            const image = $('#modalDocumentImage');
            const pdf = $('#modalDocumentPdf');
            const download = $('#modalDocumentDownload');

            if (type === 'image') {
                image.attr('src', url).show();
                pdf.hide();
            } else {
                pdf.attr('src', url).show();
                image.hide();
            }

            download.attr('href', url);
            modal.modal('show');
        }
    </script>
</x-admin.app>

