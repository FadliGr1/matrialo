<div class="modal fade" id="aws" tabindex="-1" aria-labelledby="aws" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="document-title" id="aws">Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row">
                    <form action="{{ route('aws.saveConfig') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="aws_access_key" class="form-label">Access Key</label>
                            <input required type="text" class="form-control" id="aws_access_key" name="aws_access_key" value="{{ $awsConfig->aws_access_key ?? '' }}" aria-describedby="awsAccessKeyHelp">
                            <div class="form-text" id="awsAccessKeyHelp">Masukan Access Key</div>
                        </div>
                        <div class="mb-3">
                            <label for="aws_secret_key" class="form-label">Secret Key</label>
                            <input required type="password" class="form-control" id="aws_secret_key" name="aws_secret_key" value="{{ $awsConfig->aws_secret_key ?? '' }}" aria-describedby="awsSecretKeyHelp">
                            <div class="form-text" id="awsSecretKeyHelp">Masukan Secret Key</div>
                        </div>
                        <div class="mb-3">
                            <label for="aws_bucket" class="form-label">Bucket Name</label>
                            <input required type="text" class="form-control" id="aws_bucket" name="aws_bucket" value="{{ $awsConfig->aws_bucket ?? '' }}" aria-describedby="awsBucketHelp">
                            <div class="form-text" id="awsBucketHelp">Masukan Bucket</div>
                        </div>
                        <div class="mb-3">
                            <label for="aws_region" class="form-label">Region</label>
                            <input required type="text" class="form-control" id="aws_region" name="aws_region" value="{{ $awsConfig->aws_region ?? '' }}" aria-describedby="awsRegionHelp">
                            <div class="form-text" id="awsRegionHelp">Masukan Region</div>
                        </div>
                        <div class="mb-3">
                            <label for="aws_endpoint" class="form-label">Endpoint</label>
                            <input required type="text" class="form-control" id="aws_endpoint" name="aws_endpoint" value="{{ $awsConfig->aws_endpoint ?? '' }}" aria-describedby="awsEndpointHelp">
                            <div class="form-text" id="awsEndpointHelp">Masukan Endpoint</div>
                        </div>
                        <button type="submit" class="btn btn-sm col-12 btn-primary">Simpan</button>
                    </form>
                    <form action="{{ route('aws.testConnection') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary col-12 mt-3 d-inline d-md-none" id="connectButton">
                            Test Connection
                        </button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm col-12" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>