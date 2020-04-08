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
function eey_reporting_settings_page()
{
    /*

{
    "key":"e2a1eac95dae1cb2d086ce509fd7b609",
    "defaultToken":"bdf18fa5b476080fe5c62972c6e4fa89dbd1838d86405da329956ab3fbde317a",
    "oauth": {
        "secret":"e1ab79b5d57a2f6528d0149f00ddcc6c14da304c2f4aef125f714506fa988675"
    }
}

*/
    global $wpdb;

    $settings_table = $wpdb->prefix . 'eey_reporting_settings';

    $query = "SELECT * FROM $settings_table";

    $config = $wpdb->get_results($query)[0];

    if (!$config) {

?>
        <h2>Settings</h2>

        <form method="post" id="update-settings-form">
            <h3>Trello</h3>

            <label>Trello API Key</label>
            <p>Ex: e2a1eac95dae1cb2d086ce509fd7b609</p>
            <input type="text" name="trello_api_key" />

            <label>Trello Default Token</label>
            <p>Ex: bdf18fa5b476080fe5c62972c6e4fa89dbd1838d86405da329956ab3fbde317a</p>
            <input type="text" name="trello_default_token" />

            <label>Trello OAuth Secret Key</label>
            <p>Ex: e1ab79b5d57a2f6528d0149f00ddcc6c14da304c2f4aef125f714506fa988675</p>
            <input type="text" name="trello_oauth_secret" />

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
            <button type="submit" name="update_settings">Update Settings</button>
        </form>

    <?php

    } else {

    ?>
        <h2>Settings</h2>

        <form method="post" id="update-settings-form" accept-charset="UTF-8">
            <h3>Trello</h3>

            <label>Trello API Key</label>
            <p>Ex: e2a1eac95dae1cb2d086ce509fd7b609</p>
            <input type="text" name="trello_api_key" value="<?php echo $config->trello_api_key ?>" />

            <label>Trello Default Token</label>
            <p>Ex: bdf18fa5b476080fe5c62972c6e4fa89dbd1838d86405da329956ab3fbde317a</p>
            <input type="text" name="trello_default_token" value="<?php echo $config->trello_default_token ?>" />

            <label>Trello OAuth Secret Key</label>
            <p>Ex: e1ab79b5d57a2f6528d0149f00ddcc6c14da304c2f4aef125f714506fa988675</p>
            <input type="text" name="trello_oauth_secret" value="<?php echo $config->trello_oauth_secret ?>" />

            <h3>Google Analytics</h3>

            <div> <label>Type</label>
                <p>(ex: "service_account")</p>
                <input type="text" name="ga_type" value="<?php echo $config->ga_type ?>" />
            </div>
            <div> <label>Project ID</label>
                <p>(ex: "elite-striker-269919")</p>
                <input type="text" name="ga_project_id" value="<?php echo $config->ga_project_id ?>" />
            </div>
            <div> <label>Private Key ID</label>
                <p>(ex: "b774a516a946ebc243b6d55c742677c248e225e8")</p>
                <input type="text" name="ga_private_key_id" value="<?php echo $config->ga_private_key_id ?>" />
            </div>
            <div>
                <label>Private Key</label>
                <p>(ex: "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDvALd/qJRHb3jz\nex5sXpHphYdnDquNUHaYeDsiNenxhWOOlx8VmKxW00HN1nZOj+g2f6+ItFKEZXOG\nSR8ieXPnJqcblLlVbhGFCcLNcm53C34zM/eTYMSCTuk6DGeruJb4cOJStaZQYCbc\nrME8pum5vubmw6Vl9ztWfGi//nI86RqlA4BPFHhWnRsWgo/R68sM0cjL7dA5iSh+\na5HVH72MT5Cs1/s8bPTQB/Ac1H2QHJKKJqyGswztXy4Jo+kCPWTizDBWhwzT206u\n27mj9oLDfrY27rfxQUQ2VmoDv6uh/7r4+IWmoZS1Og2XZTYOSnz582vTGfxwDZvi\n5lTdYUk5AgMBAAECggEABBY+Yl/JmVHIqbEzRfsgAkmW6nuPvMI2z535X45jH7l+\nMv6r42dRmx0lr5Vj6dgAH95zFqKuvouAPDhH4K5e/aw63fffFhzkY81U7W/Ff8z3\nLXz4ANHTdRRQXKkVpL6/+3jtWyi2sq0nkk0fSMrkjZk8GDoZkUghqvWZp57Rk++y\ntUeXAy6cU7sS3Z7NCjYCeq4Q05BPDc8gAoyw2yJkht9fwQNbjtR0z2NRR3CbZ1I3\nEmxMT5gA+xq9oj+QSxG9ovZZyl+icThjpVbiEpuFZ0O9aOLb/A8/v2hBx5DJJEKs\nLnU6gms+o22EIIKwCUCKHNCfa7htcVcrdvVx4Q/kAQKBgQD4OOxktPrjyUx1ThnO\nru1Ed4l1RV/IVWmEDuaGfkDtPQl5MaCsuXhoHqeqyJ6NYwl3fznvDYUFxiw5aOrS\ne6eDsyfSt/Z0X9gEZQJQrG1Ch9Gzl4KHF4tBiM8iKRiroKa4llk4x/pZtMbTDFm/\nAOi+MzUnFA5i5mwkOBW4VxXxQQKBgQD2fdcURJlPyoU0KwRliAcMcOm2503thJjB\nI/nVnuxK6z3gkYBGjLLXp8CrpbZHTXKAeXqoyV1pR4xVaSsHm+X5sk9eNyOFhrT3\nqCX+euc2J53uh5qXvbZb7B5i2ZwGno3Ay2Fm1vFOflvgr4+HNXR4QtgaosEEMZ6K\n05K+EKBh+QKBgApxMpil+Gv+uuWwbGuCdl7L/I9fZMEjvrWcftwnkYmpaK2dhdne\nT49pwrnviKQAB5TsWD6TPgZZKOEdZcuHAiwLLGCz9n08zvSYXzmPl2UWG59Hf2k5\nd1VBcR1Jx0zpDDp1sLkvyHtfnIGiYmAjpKbjtpe3Q0er097OMTO5DiZBAoGAGmco\nXrdqZK2gzxG8itOjTaXaowjrxAFsC2Q7IrK/RNcl7aQoRWZU0dzaOoipmcGl/jUE\n+od3Rguv8IYvYcVFQRXkgocNewQO5mhQiY3IrnhX5nEIEjD0E6ybJKOCnwLk1D30\n1Ps5JdtLJCoqCaWkMC2Y0GGWo0hdXymCknFdfKECgYEAgdkHPCBY51xWQ3zAS80F\nAKJ/J0G4vSgTvM/QMXY6oTvMBY3tWcINk6pWyNAXbKEDVEt2MrNWvoyFofpkbivr\n4UFrcQxFnBEIlYm8m4DBDI2moDMMAQZtbF0UoBcLzovfOFvzzlbYcAviY/Fzky2c\nvCGxWnlNaj2Ui1SsZq6C3nE=\n-----END PRIVATE KEY-----\n")</p>
                <input type="text" name="ga_private_key" value="<?php echo $config->ga_private_key ?>" />

            </div>
            <div> <label>Client Email</label>
                <p>(ex: "eey-reporting-api@elite-striker-269919.iam.gserviceaccount.com")</p>
                <input type="text" name="ga_client_email" value="<?php echo $config->ga_client_email ?>" />
            </div>
            <div> <label>Client ID</label>
                <p>(ex: "113352123685122293144")</p>
                <input type="text" name="ga_client_id" value="<?php echo $config->ga_client_id ?>" />
            </div>
            <div> <label>Auth URI</label>
                <p>(ex: "https://accounts.google.com/o/oauth2/auth")</p>
                <input type="text" name="ga_auth_uri" value="<?php echo $config->ga_auth_uri ?>" />

            </div>
            <div> <label>Token URI</label>
                <p>(ex: "https://oauth2.googleapis.com/token")</p>
                <input type="text" name="ga_token_uri" value="<?php echo $config->ga_token_uri ?>" />
            </div>

            <div> <label>Auth Provider x509 Cert URL</label>
                <p>(ex: "https://www.googleapis.com/oauth2/v1/certs")</p>
                <input type="text" name="ga_auth_provider_x509_cert_url" value="<?php echo $config->ga_auth_provider_x509_cert_url ?>" />
            </div>


            <div> <label>Client x509 Cert URL</label>
                <p>(ex: "https://www.googleapis.com/robot/v1/metadata/x509/eey-reporting-api%40elite-striker-269919.iam.gserviceaccount.com")</p>
                <input type="text" name="ga_client_x509_cert_url" value="<?php echo $config->ga_client_x509_cert_url ?>" />
            </div>
            <button type="submit" name="update_settings">Update Settings</button>
        </form>

<?php

    }
}
function eey_reporting_update_settings()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'eey_reporting_settings';

    $EEY_trello_api_key = $_POST['trello_api_key'];
    $EEY_trello_default_token = $_POST['trello_default_token'];
    $EEY_trello_oauth_secret = $_POST['trello_oauth_secret'];
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

    

    if (isset($_POST['update_settings'])) {
        $query = "SELECT ID FROM $table_name";
        $result = $wpdb->get_results($query)[0];
        if ($result) {
            $wpdb->update(
                $table_name,
                array(
                    'trello_api_key' => stripslashes($EEY_trello_api_key),
                    'trello_default_token' => stripslashes($EEY_trello_default_token),
                    'trello_oauth_secret' => stripslashes($EEY_trello_oauth_secret),
                    'ga_type' => stripslashes($EEY_ga_type),
                    'ga_project_id' => stripslashes($EEY_ga_project_id),
                    'ga_private_key_id' => stripslashes($EEY_ga_private_key_id),
                    'ga_private_key' => stripslashes($EEY_ga_private_key),
                    'ga_client_email' => stripslashes($EEY_ga_client_email),
                    'ga_client_id' => stripslashes($EEY_ga_client_id),
                    'ga_auth_uri' => stripslashes($EEY_ga_auth_uri),
                    'ga_token_uri' => stripslashes($EEY_ga_token_uri),
                    'ga_auth_provider_x509_cert_url' => stripslashes($EEY_ga_auth_provider_x509_cert_url),
                    'ga_client_x509_cert_url' => stripslashes($EEY_ga_client_x509_cert_url)
                ),
                array('ID' => $result->ID),
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
                    '%s',
                    '%s'
                )
            );
        } else {
            $wpdb->insert(
                $table_name,
                array(
                    'trello_api_key' => stripslashes($EEY_trello_api_key),
                    'trello_default_token' => stripslashes($EEY_trello_default_token),
                    'trello_oauth_secret' => stripslashes($EEY_trello_oauth_secret),
                    'ga_type' => stripslashes($EEY_ga_type),
                    'ga_project_id' => stripslashes($EEY_ga_project_id),
                    'ga_private_key_id' => stripslashes($EEY_ga_private_key_id),
                    'ga_private_key' => stripslashes($EEY_ga_private_key),
                    'ga_client_email' => stripslashes($EEY_ga_client_email),
                    'ga_client_id' => stripslashes($EEY_ga_client_id),
                    'ga_auth_uri' => stripslashes($EEY_ga_auth_uri),
                    'ga_token_uri' => stripslashes($EEY_ga_token_uri),
                    'ga_auth_provider_x509_cert_url' => stripslashes($EEY_ga_auth_provider_x509_cert_url),
                    'ga_client_x509_cert_url' => stripslashes($EEY_ga_client_x509_cert_url)
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
                    '%s',
                    '%s'
                )
            );
        }
    }
}
