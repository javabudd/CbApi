<?php

namespace CBApi\Server;

/**
 * Class TestServer
 *
 * @package CBApi\Server
 */
class TestServer extends \Threaded
{
    const IP             = '127.0.0.1';
    const PORT           = '6969';
    const PEM_PASSPHRASE = 'test';

    /** @var string */
    protected $pemFile = '/../files/test.pem';

    /** @var array */
    protected static $pemDN = [
        'countryName'            => 'US',
        'stateOrProvinceName'    => 'Colorado',
        'localityName'           => 'Test',
        'organizationName'       => 'Test Inc',
        'organizationalUnitName' => 'Test Dep',
        'commonName'             => '127.0.0.1',
        'emailAddress'           => 'email@test.com'
    ];

    public function run()
    {
        $this->pemFile = __DIR__ . $this->pemFile;
        if (!file_exists($this->pemFile)) {
            $this->createSSLCert();
        }

        $this->createStreamServer();
    }

    private function createSSLCert()
    {
        $privKey = openssl_pkey_new();
        $cert    = openssl_csr_new(self::$pemDN, $privKey);
        $cert    = openssl_csr_sign($cert, null, $privKey, 365);
        $pem     = [];

        openssl_x509_export($cert, $pem[0]);
        openssl_pkey_export($privKey, $pem[1], self::PEM_PASSPHRASE);

        $pem = implode($pem);
        file_put_contents($this->pemFile, $pem);
        chmod($this->pemFile, 0600);
    }

    private function createStreamServer()
    {
        $context = stream_context_create();

        stream_context_set_option($context, 'ssl', 'local_cert', $this->pemFile);
        stream_context_set_option($context, 'ssl', 'passphrase', self::PEM_PASSPHRASE);
        stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
        stream_context_set_option($context, 'ssl', 'verify_peer', false);

        $socket = stream_socket_server(
            sprintf('tcp://%s:%s', self::IP, self::PORT),
            $errno,
            $errstr,
            STREAM_SERVER_BIND | STREAM_SERVER_LISTEN,
            $context
        );
        stream_socket_enable_crypto($socket, false);

        $this->executeStreamServer($socket);
    }

    private function executeStreamServer($socket)
    {
        $exit = false;
        while ($exit === false) {
            $forkedSocket = stream_socket_accept($socket, '-1', $remoteIp);

            stream_set_blocking($forkedSocket, true);
            stream_socket_enable_crypto($forkedSocket, true, STREAM_CRYPTO_METHOD_SSLv3_SERVER);

            $data = fread($forkedSocket, 8192);
            if (substr($data, 0, 16) === 'GET /stop-server') {
                $exit = true;
            }

            stream_set_blocking($forkedSocket, false);
            fwrite($forkedSocket, 'Response!');
            fclose($forkedSocket);
        }
        exit(0);
    }
}
