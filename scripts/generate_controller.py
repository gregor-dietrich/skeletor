
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

        if "Users" in module["has_one"]:
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
                   indent + indent + "$this->authService->checkAccess();\n" +
                   indent + indent + "$savedSuccess = false;\n")
        for item in module["has_one"]:
            if item.lower() == "users":
                continue
            file.write(indent + indent + "$%s = $this->%sRepository->findAll();\n" % (item.lower(), item.lower()))
        file.write(indent + indent + "if (")
        for item in module["properties"]:
            if item in module["optionals"] or item in ["id", "user_id"]:
                continue
            file.write("!empty($_POST['%s'])" % item)
            if item != module["properties"][-1]:
                file.write(" AND ")
        if "user_id" in module["properties"] and "user_id" not in module["optionals"]:
            file.write("!empty($_POST['user_id']) AND " +
                       "$this->usersRepository->findUsername($_SESSION['login'])->id == $_POST['user_id']")
        file.write(") {\n")
        for item in module["properties"]:
            if item == "id":
                continue
            if item in module["optionals"]:
                file.write(indent + indent + indent + "if (!empty($_POST['%s'])) {\n" % item +
                           indent + indent + indent + indent + "$%s = $_POST['%s'];\n" % (item, item) +
                           indent + indent + indent + "} else {\n" +
                           indent + indent + indent + indent + "$%s = NULL;\n" % item +
                           indent + indent + indent + "}\n")
            else:
                file.write(indent + indent + indent + "$%s = $_POST['%s'];\n" % (item, item))
        file.write(indent + indent + indent + "$this->%sRepository->insert(" % module["plural"].lower())
        for item in module["properties"]:
            if item == "id":
                continue
            file.write("$%s" % item)
            if item != module["properties"][-1]:
                file.write(", ")
        file.write(");\n" +
                   indent + indent + indent + "$savedSuccess = true;\n" +
                   indent + indent + "}\n" +
                   indent + indent + "$this->render(\"")
        if module["namespace"] != module["name"] and module["namespace"] != "":
            file.write(module["namespace"].lower() + "/")
        file.write("%s/admin/add\", [\n" % module["name"].lower())
        for item in module["has_one"]:
            if item.lower() == "users":
                continue
            file.write(indent + indent + indent + "'%s' => $%s,\n" % (item.lower(), item.lower()))
        file.write(indent + indent + indent + "'savedSuccess' => $savedSuccess"
                   "\n" + indent + indent + "]);\n" + indent + "}\n\n")

        file.write(indent + "public function admin_index()\n" +
                   indent + "{\n" +
                   indent + indent + "$this->authService->checkAccess();\n" +
                   indent + indent + "$%s = $this->%sRepository->findAll();\n"
                   % (module["plural"].lower(), module["plural"].lower()) +
                   indent + indent + "rsort($%s);\n" % module["plural"].lower() +
                   indent + indent + "$this->render(\"")
        if module["namespace"] != module["name"] and module["namespace"] != "":
            file.write(module["namespace"].lower() + "/")
        file.write("%s/admin/index\", ['%s' => $%s]);\n"
                   % (module["name"].lower(), module["plural"].lower(), module["plural"].lower()) +
                   indent + "}\n\n")

        file.write(indent + "public function delete()\n" +
                   indent + "{\n" +
                   indent + indent + "if (!$this->authService->checkAccess()) {\n" +
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
                   indent + indent + "$this->authService->checkAccess();\n" +
                   indent + indent + "$savedSuccess = false;\n" +
                   indent + indent + "$id = $_GET['id'];\n" +
                   indent + indent + "$entry = $this->%sRepository->findID($id);\n" % module["plural"].lower())
        # TO DO START
        for item in module["has_one"]:
            if item.lower() == "users":
                continue
            file.write(indent + indent + "$%s = $this->%sRepository->findAll();\n" % (item.lower(), item.lower()))
        file.write(indent + indent + "if (")
        counter = 0
        for item in module["properties"]:
            counter += 1
            if item in module["optionals"] or item in ["id", "user_id"]:
                continue
            file.write("!empty($_POST['%s'])" % item)
            if counter < len(module["properties"]) - 1:
                file.write(" AND ")
                counter += 1
        file.write(") {\n")
        for item in module["properties"]:
            if item in ["id", "user_id"]:
                continue
            if item in module["optionals"]:
                file.write(indent + indent + indent + "if (!empty($_POST['%s'])) {\n" % item +
                           indent + indent + indent + indent + "$entry->%s = $_POST['%s'];\n" % (item, item) +
                           indent + indent + indent + "} else {\n" +
                           indent + indent + indent + indent + "$entry->%s = NULL;\n" % item +
                           indent + indent + indent + "}\n")
            else:
                file.write(indent + indent + indent + "$entry->%s = $_POST['%s'];\n" % (item, item))
        file.write(indent + indent + indent + "$this->%sRepository->update($entry);\n" % module["plural"].lower() +
                   indent + indent + indent + "$savedSuccess = true;\n" +
                   indent + indent + "}\n" +
                   indent + indent + "$this->render(\"")
        if module["namespace"] != module["name"] and module["namespace"] != "":
            file.write(module["namespace"].lower() + "/")
        file.write("%s/admin/edit\", [\n" % module["name"].lower() + 3 * indent + "'entry' => $entry,\n")
        for item in module["has_one"]:
            if item.lower() == "users":
                continue
            file.write(indent + indent + indent + "'%s' => $%s,\n" % (item.lower(), item.lower()))
        file.write(indent + indent + indent + "'savedSuccess' => $savedSuccess"
                   "\n" + indent + indent + "]);\n" + indent + "}\n")
        # TO DO END

        file.write(indent + "public function index()\n" +
                   indent + "{\n" +
                   indent + indent + "$%s = $this->%sRepository->findAll();\n"
                   % (module["plural"].lower(), module["plural"].lower()) +
                   indent + indent + "rsort($%s);\n" % module["plural"].lower() +
                   indent + indent + "$this->render(\"")
        if module["namespace"] != module["name"] and module["namespace"] != "":
            file.write(module["namespace"].lower() + "/")
        file.write("%s/index\", ['%s' => $%s]);\n"
                   % (module["name"].lower(), module["plural"].lower(), module["plural"].lower()) +
                   indent + "}\n\n")

        file.write(indent + "public function show()\n" +
                   indent + "{\n" +
                   indent + indent + "$id = $_GET['id'];\n")
        for item in module["has_many"]:
            file.write(indent + indent + "// Code for adding %s by id(?)\n\n" % item)
        file.write(indent + indent + "$%s = $this->%sRepository->findID($id);\n" %
                   (module["name"].lower(), module["plural"].lower()))
        for item in module["has_many"]:
            file.write(indent + indent + "$%s = $this->%sRepository->fetchAllByID($id);\n"
                       % (item.lower(), item.lower()))
        file.write(indent + indent + "$this->render(\"")
        if module["namespace"] != module["name"] and module["namespace"] != "":
            file.write(module["namespace"].lower() + "/")
        file.write("%s/show\", [\n" % module["name"].lower() + indent + indent + indent + "'%s' => $%s"
                   % (module["name"].lower(), module["name"].lower()))
        for item in module["has_many"]:
            file.write(",\n" + indent + indent + indent + "'%s' => $%s" % (item.lower(), item.lower()))
        file.write("\n" + indent + indent + "]);\n" + indent + "}\n")

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
