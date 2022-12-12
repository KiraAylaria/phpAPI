<?php

    class ProductController extends Controller
    {

        public function __construct(ProductGateway $gateway)
        {
            parent::__construct($gateway);
        }

        public function processRequest(string $method, ?string $id) : void
        {
            // Decide if ressource or collection request (no id provided)
            if ($id) {
                $this->processResourceRequest($method, $id);
            } else {
                $this->processCollectionRequest($method);
            }
        }

        protected function processResourceRequest(string $method, string $id) : void
        {
            $product = $this->gateway->get($id);

            // Check if product exists
            if (!$product) {
                // Not Found
                http_response_code(404);
                echo json_encode(['message' => 'Product not found']);
                return;
            }

            // Allowed methods for the ressource
            switch ($method) {
                case 'GET':
                    echo json_encode($product);
                    break;

                case 'PATCH':
                    $data = (array) json_decode(file_get_contents("php://input"), true);
                    $errors = $this->getValidationErrors($data, false);

                    if (!empty($errors)) {
                        // Unprocessable Entity
                        http_response_code(422);
                        echo json_encode(['errors' => $errors]);
                        break;
                    }

                    $rows = $this->gateway->update($product, $data);

                    echo json_encode([
                        'message' => "Product $id updated",
                        'id' => $id
                    ]);
                    break;

                case 'DELETE':
                    $rows = $this->gateway->delete($id);
                    echo json_encode([
                        'message' => "Product $id deleted",
                        'rows' => $rows
                    ]);
                    break;

                default:
                    // Method not allowed
                    http_response_code(405);
                    header("Allow: GET, PATCH, DELETE");
                    break;
            }
        }

        protected function processCollectionRequest(string $method) : void 
        {
            // Allowed methods for the collection
            switch ($method) {
                case 'GET':
                    echo json_encode($this->gateway->getAll());
                    break;
                
                case 'POST':
                    $data = (array) json_decode(file_get_contents("php://input"), true);
                    $errors = $this->getValidationErrors($data);

                    if (!empty($errors)) {
                        // Unprocessable Entity
                        http_response_code(422);
                        echo json_encode(['errors' => $errors]);
                        break;
                    }

                    $id = $this->gateway->create($data);

                    // Created
                    http_response_code(201);

                    echo json_encode([
                        'message' => 'Product created',
                        'id' => $id
                    ]);
                    break;

                default:
                    // Method not allowed
                    http_response_code(405);
                    header("Allow: GET, POST");
                    break;
            }
        }

        protected function getValidationErrors(array $data, bool $is_new = true) : array
        {
            $errors = [];

            if ($is_new && empty($data['name'])) {
                $errors[] = "name is required";
            }
            if ($is_new && empty($data['size'])) {
                $errors[] = "size is required";
            }
            if (array_key_exists('size', $data)) {
                if (filter_var($data['size'], FILTER_VALIDATE_INT) === false) {
                    $errors[] = "size must be an integer";
                }
            }

            return $errors;
        }

    }