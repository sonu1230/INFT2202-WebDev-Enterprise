<?php
namespace Application;

class Page {
    // Setting response type to JSON 
    private function jsonHeader(): void {
        header('Content-Type: application/json; charset=utf-8');
    }
    public function list($items) {
        http_response_code(200);
        echo json_encode($items);
    }

    public function item($item = false) {
        http_response_code(200);
        if ($item) {
            echo json_encode($item);
        }
    }

    public function notFound() {
        http_response_code(404);
        echo json_encode(["error" => "Not found"]);
    }

    public function badRequest() {
        http_response_code(400);
        echo json_encode(["error" => "Bad request"]);
    }
}
