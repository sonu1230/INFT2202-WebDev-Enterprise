<?php
namespace Application;

class Page {

    private function jsonHeader(): void {
        header('Content-Type: application/json; charset=utf-8');
    }

    public function list($items) {
        $this->jsonHeader();
        http_response_code(200);
        echo json_encode($items);
    }

    public function item($item = false) {
        $this->jsonHeader();
        http_response_code(200);
        if ($item !== false) {
            echo json_encode($item);
        }
    }

    public function notFound() {
        $this->jsonHeader();
        http_response_code(404);
        echo json_encode(["error" => "Not found"]);
    }

    public function badRequest() {
        $this->jsonHeader();
        http_response_code(400);
        echo json_encode(["error" => "Bad request"]);
    }
}
