<?php

// Form Design
/*
                    domain_name
                    trello_board_id
                    ga_type
                    ga_project_id
                    ga_private_key_id
                    ga_private_key
                    ga_client_email
                    ga_client_id
                    ga_auth_uri
                    ga_auth_token
                    ga_auth_provider_x509_cert_url
                    ga_client_x509_cert_url
*/
function eey_reporting_add_website()
{


?>
    <h1>Add a Website</h1>

    <form method="post" id="add-site-form">
        <div>
            <label>Domain Name</label>
            <input type="text" name="domain_name" />
        </div>


        <h3>Trello</h3>

        <label>Trello Board ID</label>
        <p>( Found on Show Menu -> More -> https://trello.com/b/[Trello Board ID] )</p>
        <input type="text" name="trello_board_id" />

        <h3>Google Analytics</h3>

        <div> <label>Type</label>
            <p>(ex: "service_account")</p>
            <input type="text" name="ga_type" />
        </div>
        <div> <label>Project ID</label>
            <p>(ex: "elite-striker-269919")</p>
            <input type="text" name="ga_project_id" />
        </div>
        <div> <label>Private Key ID</label>
            <p>(ex: "b774a516a946ebc243b6d55c742677c248e225e8")</p>
            <input type="text" name="ga_private_key_id" />
        </div>
        <div>
            <label>Private Key</label>
            <p>(ex: "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDvALd/qJRHb3jz\nex5sXpHphYdnDquNUHaYeDsiNenxhWOOlx8VmKxW00HN1nZOj+g2f6+ItFKEZXOG\nSR8ieXPnJqcblLlVbhGFCcLNcm53C34zM/eTYMSCTuk6DGeruJb4cOJStaZQYCbc\nrME8pum5vubmw6Vl9ztWfGi//nI86RqlA4BPFHhWnRsWgo/R68sM0cjL7dA5iSh+\na5HVH72MT5Cs1/s8bPTQB/Ac1H2QHJKKJqyGswztXy4Jo+kCPWTizDBWhwzT206u\n27mj9oLDfrY27rfxQUQ2VmoDv6uh/7r4+IWmoZS1Og2XZTYOSnz582vTGfxwDZvi\n5lTdYUk5AgMBAAECggEABBY+Yl/JmVHIqbEzRfsgAkmW6nuPvMI2z535X45jH7l+\nMv6r42dRmx0lr5Vj6dgAH95zFqKuvouAPDhH4K5e/aw63fffFhzkY81U7W/Ff8z3\nLXz4ANHTdRRQXKkVpL6/+3jtWyi2sq0nkk0fSMrkjZk8GDoZkUghqvWZp57Rk++y\ntUeXAy6cU7sS3Z7NCjYCeq4Q05BPDc8gAoyw2yJkht9fwQNbjtR0z2NRR3CbZ1I3\nEmxMT5gA+xq9oj+QSxG9ovZZyl+icThjpVbiEpuFZ0O9aOLb/A8/v2hBx5DJJEKs\nLnU6gms+o22EIIKwCUCKHNCfa7htcVcrdvVx4Q/kAQKBgQD4OOxktPrjyUx1ThnO\nru1Ed4l1RV/IVWmEDuaGfkDtPQl5MaCsuXhoHqeqyJ6NYwl3fznvDYUFxiw5aOrS\ne6eDsyfSt/Z0X9gEZQJQrG1Ch9Gzl4KHF4tBiM8iKRiroKa4llk4x/pZtMbTDFm/\nAOi+MzUnFA5i5mwkOBW4VxXxQQKBgQD2fdcURJlPyoU0KwRliAcMcOm2503thJjB\nI/nVnuxK6z3gkYBGjLLXp8CrpbZHTXKAeXqoyV1pR4xVaSsHm+X5sk9eNyOFhrT3\nqCX+euc2J53uh5qXvbZb7B5i2ZwGno3Ay2Fm1vFOflvgr4+HNXR4QtgaosEEMZ6K\n05K+EKBh+QKBgApxMpil+Gv+uuWwbGuCdl7L/I9fZMEjvrWcftwnkYmpaK2dhdne\nT49pwrnviKQAB5TsWD6TPgZZKOEdZcuHAiwLLGCz9n08zvSYXzmPl2UWG59Hf2k5\nd1VBcR1Jx0zpDDp1sLkvyHtfnIGiYmAjpKbjtpe3Q0er097OMTO5DiZBAoGAGmco\nXrdqZK2gzxG8itOjTaXaowjrxAFsC2Q7IrK/RNcl7aQoRWZU0dzaOoipmcGl/jUE\n+od3Rguv8IYvYcVFQRXkgocNewQO5mhQiY3IrnhX5nEIEjD0E6ybJKOCnwLk1D30\n1Ps5JdtLJCoqCaWkMC2Y0GGWo0hdXymCknFdfKECgYEAgdkHPCBY51xWQ3zAS80F\nAKJ/J0G4vSgTvM/QMXY6oTvMBY3tWcINk6pWyNAXbKEDVEt2MrNWvoyFofpkbivr\n4UFrcQxFnBEIlYm8m4DBDI2moDMMAQZtbF0UoBcLzovfOFvzzlbYcAviY/Fzky2c\nvCGxWnlNaj2Ui1SsZq6C3nE=\n-----END PRIVATE KEY-----\n")</p>
            <input type="text" name="ga_private_key" />

        </div>
        <div> <label>Client Email</label>
            <p>(ex: "eey-reporting-api@elite-striker-269919.iam.gserviceaccount.com")</p>
            <input type="text" name="ga_client_email" />
        </div>
        <div> <label>Client ID</label>
            <p>(ex: "113352123685122293144")</p>
            <input type="text" name="ga_client_id" />
        </div>
        <div> <label>Auth URI</label>
            <p>(ex: "https://accounts.google.com/o/oauth2/auth")</p>
            <input type="text" name="ga_auth_uri" />

        </div>
        <div> <label>Token URI</label>
            <p>(ex: "https://oauth2.googleapis.com/token")</p>
            <input type="text" name="ga_token_uri" />
        </div>

        <div> <label>Auth Provider x509 Cert URL</label>
            <p>(ex: "https://www.googleapis.com/oauth2/v1/certs")</p>
            <input type="text" name="ga_auth_provider_x509_cert_url" />
        </div>


        <div> <label>Client x509 Cert URL</label>
            <p>(ex: "https://www.googleapis.com/robot/v1/metadata/x509/eey-reporting-api%40elite-striker-269919.iam.gserviceaccount.com")</p>
            <input type="text" name="ga_client_x509_cert_url" />
        </div>
        <button type="submit" name="add_website">Add Website</button>
    </form>

<?php


}
function eey_reporting_insert_website()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'eey_reporting_websites';

    $EEY_domain_name = $_POST['domain_name'];
    $EEY_trello_board_id = $_POST['trello_board_id'];
    $EEY_ga_type = $_POST['ga_type'];
    $EEY_ga_project_id = $_POST['ga_project_id'];
    $EEY_ga_private_key_id = $_POST['ga_private_key_id'];
    $EEY_ga_private_key = $_POST['ga_private_key'];
    $EEY_ga_client_email = $_POST['ga_client_email'];
    $EEY_ga_client_id = $_POST['ga_client_id'];
    $EEY_ga_auth_uri = $_POST['ga_auth_uri'];
    $EEY_ga_token_uri = $_POST['ga_token_uri'];
    $EEY_ga_auth_provider_x509_cert_url = $_POST['ga_auth_provider_x509_cert_url'];
    $EEY_ga_client_x509_cert_url = $_POST['ga_client_x509_cert_url'];

    if (isset($_POST['add_website'])) {

        $wpdb->insert(
            $table_name,
            array(
                'domain_name' => $EEY_domain_name,
                'trello_board_id' => $EEY_trello_board_id,
                'ga_type' => $EEY_ga_type,
                'ga_project_id' => $EEY_ga_project_id,
                'ga_private_key_id' => $EEY_ga_private_key_id,
                'ga_private_key' => $EEY_ga_private_key,
                'ga_client_email' => $EEY_ga_client_email,
                'ga_client_id' => $EEY_ga_client_id,
                'ga_auth_uri' => $EEY_ga_auth_uri,
                'ga_token_uri' => $EEY_ga_token_uri,
                'ga_auth_provider_x509_cert_url' => $EEY_ga_auth_provider_x509_cert_url,
                'ga_client_x509_cert_url' => $EEY_ga_client_x509_cert_url
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );
    }
}
