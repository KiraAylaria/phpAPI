<?php

    class UserController extends Controller
    {

        public function __construct(UserGateway $gateway)
        {
            parent::__construct($gateway);
        }

        public function processRequest(string $method, ?string $id) : void
        {
            if ($id) {
                $this->processResourceRequest($method, $id);
            } else {
                $this->processCollectionRequest($method);
            }
        }

        protected function processResourceRequest(string $method, string $id) : void
        {
            $user = $this->gateway->get($id);

            // Check if user exists
            if (!$user) {
                // Not Found
                http_response_code(404);
                echo json_encode(['message' => 'User not found']);
                return;
            }

            // Allowed methods for the ressource
            switch ($method) {
                case 'GET':
                    echo json_encode($user);
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

                    $rows = $this->gateway->update($user, $data);

                    echo json_encode([
                        'message' => "User $id updated",
                        'id' => $id
                    ]);
                    break;

                case 'DELETE':
                    $rows = $this->gateway->delete($id);
                    echo json_encode([
                        'message' => "User $id deleted",
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
                        'message' => 'User created',
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
            if (array_key_exists('size', $data)) {
                if (filter_var($data['size'], FILTER_VALIDATE_INT) === false) {
                    $errors[] = "size must be an integer";
                }
            }

            return $errors;
        }

    }