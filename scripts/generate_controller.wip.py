
import json
import os
import sys


def check_folders(subdir):
    sub_dirs = subdir.split("/")
    make_dir = sub_dirs[0] + "/"
    for dir_name in sub_dirs[1:]:
        make_dir += dir_name + "/"
        if not os.path.exists(os.path.join(make_dir)):
            os.mkdir(os.path.join(make_dir))


def parse_json(filename, charset):
    print("%s found! Reading contents..." % filename)
    with open(filename, "r", encoding=charset) as file:
        data = file.read()
    module = json.loads(data)

    for k, v in module.items():
        if k in ["name", "plural", "namespace"]:
            module[k] = v.capitalize()

    if module["namespace"] == "":
        module["namespace"] = module["name"]
    print("Successfully read JSON file.")
    return module


def write_controller(module, charset):
    check_folders("./modules/generated/")
    filename = "./modules/generated/" + module["plural"] + "Controller.php"
    print("Writing to %s..." % filename)
    with open(filename, "w", encoding=charset) as file:
        indent = 4 * " "

        file.write("<?php\n\n" +
                   "namespace App\\" + module["namespace"] + ";\n\n" +
                   "use App\\Core\\AbstractController;\n" +
                   "use App\\User\\AuthService;\n")

        if "User" in module["has_one"]:
            file.write("use App\\User\\UsersRepository;\n")

        file.write("\nclass " + module["plural"] + "Controller extends AbstractController\n" +
                   "{\n" +
                   indent + "public function __construct(%sRepository $%sRepository, "
                   % (module["plural"].capitalize(), module["plural"].lower()))
        for item in module["has_many"] + module["has_one"]:
            file.write("%sRepository $%sRepository, " % (item.capitalize(), item.lower()))
        file.write("AuthService $authService)\n" +
                   indent + "{\n" +
                   indent + indent + "$this->%sRepository = $%sRepository;\n"
                   % (module["plural"].lower(), module["plural"].lower()))
        for item in module["has_many"] + module["has_one"]:
            file.write(indent + indent + "$this->%sRepository = $%sRepository;\n" % (item.lower(), item.lower()))
        file.write(indent + indent + "$this->authService = $authService;\n" +
                   indent + "}\n\n")

        file.write(indent + "public function add()\n" +
                   indent + "{\n" +
                   indent + indent + "$this->authService->check();\n" +
                   indent + indent + "$savedSuccess = false;\n" +
                   indent + "}\n\n")
        # TO DO

        file.write(indent + "public function admin_index()\n" +
                   indent + "{\n" +
                   indent + indent + "$this->authService->check();\n" +
                   indent + indent + "$%s = $this->%sRepository->findAll();\n"
                   % (module["plural"].lower(), module["plural"].lower()) +
                   indent + indent + "rsort($%s);\n" % module["plural"].lower() +
                   indent + indent + "$this->render(\"%s/admin/index\", ['%s' => $%s]);\n"
                   % (module["name"].lower(), module["plural"].lower(), module["plural"].lower()) +
                   indent + "}\n\n")

        file.write(indent + "public function delete()\n" +
                   indent + "{\n" +
                   indent + indent + "if (!$this->authService->check()) {\n" +
                   indent + indent + indent + "die();\n" +
                   indent + indent + "} else {\n" +
                   indent + indent + indent + "$id = $_GET['id'];\n" +
                   indent + indent + indent + "$%s = $this->%sRepository->findID($id);\n"
                   % (module["name"].lower(), module["plural"].lower()) +
                   indent + indent + indent + "if (!empty($%s)) {\n" % module["name"].lower() +
                   indent + indent + indent + indent + "$this->%sRepository->delete($id);\n"
                   % module["plural"].lower() +
                   indent + indent + indent + "}\n" +
                   indent + indent + indent + "$this->admin_index();\n" +
                   indent + indent + "}\n" +
                   indent + "}\n\n")

        file.write(indent + "public function edit()\n" +
                   indent + "{\n" +
                   indent + indent + "$this->authService->check();\n" +
                   indent + indent + "$savedSuccess = false;\n" +
                   indent + indent + "$id = $_GET['id'];\n" +
                   indent + "}\n\n")
        # TO DO

        file.write(indent + "public function index()\n" +
                   indent + "{\n" +
                   indent + indent + "$%s = $this->%sRepository->findAll();\n"
                   % (module["plural"].lower(), module["plural"].lower()) +
                   indent + indent + "rsort($%s);\n" % module["plural"].lower() +
                   indent + indent + "$this->render(\"%s/index\", ['%s' => $%s]);\n"
                   % (module["name"].lower(), module["plural"].lower(), module["plural"].lower()) +
                   indent + "}\n\n")

        file.write(indent + "public function show()\n" +
                   indent + "{\n" +
                   indent + indent + "$id = $_GET['id'];\n" +
                   indent + "}\n")
        # TO DO

        file.write("}\n")
        print("Finished writing %s." % filename)


def main():
    print("Enter JSON filename:")
    filename = "./modules/" + input("./modules/")

    if os.path.isfile(filename):
        module = parse_json(filename, "utf-8")
        write_controller(module, "utf-8")
    else:
        print("Error: Couldn't read %s." % filename)

    print("All operations completed. Exiting...")
    sys.exit()


main()
