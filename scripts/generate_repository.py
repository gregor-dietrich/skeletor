
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


def write_repository(module, charset):
    check_folders("./modules/generated/")
    filename = "./modules/generated/" + module["plural"] + "Repository.php"
    print("Writing to %s..." % filename)
    with open(filename, "w", encoding=charset) as file:
        indent = 4 * " "

        file.write("<?php\n\n" +
                   "namespace App\\" + module["namespace"] + ";\n\n" +
                   "use App\\Core\\AbstractRepository;\n\n" +
                   "class " + module["plural"] + "Repository extends AbstractRepository\n" +
                   "{\n")

        file.write(indent + "public function getModelName()\n" +
                   indent + "{\n")
        if module["namespace"] != module["name"]:
            file.write(indent + indent + "return \"App\\\\%s\\\\%sModel\";\n" % (module["namespace"], module["name"]))
        else:
            file.write(indent + indent + "return \"App\\\\%sModel\";\n" % (module["name"]))
        file.write(indent + "}\n\n")

        file.write(indent + "public function getTableName()\n" +
                   indent + "{\n")
        if module["namespace"] != module["name"]:
            file.write(indent + indent + "return \"%s_%s\";\n" % (module["namespace"].lower(), module["plural"].lower()))
        else:
            file.write(indent + indent + "return \"%s\";\n" % (module["plural"].lower()))
        file.write(indent + "}\n\n")

        file.write(indent + "public function insert(")
        for value in module["properties"][1:]:
            file.write("$%s" % value)
            if value != module["properties"][-1]:
                file.write(", ")
        file.write(")\n" + indent + "{\n" +
                   indent + indent + "$table = $this->getTableName();\n\n" +
                   indent + indent + "$stmt = $this->pdo->prepare(\"INSERT INTO `{$table}` (")
        for value in module["properties"][1:]:
            file.write("`%s`" % value)
            if value != module["properties"][-1]:
                file.write(", ")
        file.write(") VALUES (")
        for value in module["properties"][1:]:
            file.write(":%s" % value)
            if value != module["properties"][-1]:
                file.write(", ")
        file.write(")\");\n" +
                   indent + indent + "$stmt->execute([\n")
        for value in module["properties"][1:]:
            file.write(indent + indent + indent + "'%s' => $%s," % (value, value))
            file.write("\n")
        file.write(indent + indent + "]);\n" +
                   indent + "}\n\n")

        file.write(indent + "public function update(%sModel $model)\n" % (module["name"]) +
                   indent + "{\n")
        file.write(indent + indent + "$table = $this->getTableName();\n\n")
        file.write(indent + indent + "$stmt = $this->pdo->prepare(\"UPDATE `{$table}` SET ")
        for value in module["properties"][1:]:
            file.write("`%s` = :%s" % (value, value))
            if value != module["properties"][-1]:
                file.write(",")
            file.write(" ")
        file.write("WHERE `id` = :id\");\n" +
                   indent + indent + "$stmt->execute([\n")
        for value in module["properties"][1:]:
            file.write(indent + indent + indent + "'%s' => $model->%s," % (value, value))
            file.write("\n")
        file.write(indent + indent + indent + "'id' => $model->id\n" +
                   indent + indent + "]);\n")
        file.write(indent + "}\n")

        file.write("}\n")
    print("Finished writing %s." % filename)


def main():
    print("Enter JSON filename:")
    filename = "./modules/" + input("./modules/")

    if os.path.isfile(filename):
        module = parse_json(filename, "utf-8")
        write_repository(module, "utf-8")
    else:
        print("Error: Couldn't read %s." % filename)

    print("All operations completed. Exiting...")
    sys.exit()


main()
