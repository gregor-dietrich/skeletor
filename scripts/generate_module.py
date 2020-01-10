
import json
import os
import sys


def get_input():
    module = {}
    settings = [
        "name",
        "plural",
        "namespace",
        "properties",
        "has_many",
        "has_one"
    ]

    for setting in settings:
        if setting == "namespace":
            module[setting] = input("%s: App\\" % setting).capitalize()
        else:
            module[setting] = input("%s: " % setting).capitalize()

        if ", " in module[setting]:
            module[setting] = module[setting].replace(",", "")
            module[setting] = module[setting].split()

        if isinstance(module[setting], str) and not (setting in settings[:3]):
            if module[setting] != "":
                module[setting] = [module[setting]]
            else:
                module[setting] = []

    for k, v in module.items():
        if k in ["name", "plural", "namespace"]:
            module[k] = v.capitalize()
        elif k == "properties":
            for i in range(len(module[k])):
                module[k][i] = module[k][i].lower()
        elif k in ["has_many", "has_one"]:
            for i in range(len(module[k])):
                module[k][i] = module[k][i].capitalize()

    return module


def check_folders(subdir):
    sub_dirs = subdir.split("/")
    make_dir = sub_dirs[0] + "/"
    for dir_name in sub_dirs[1:]:
        make_dir += dir_name + "/"
        if not os.path.exists(os.path.join(make_dir)):
            os.mkdir(os.path.join(make_dir))


def main():
    module = get_input()

    check_folders("./modules/generated/")
    if module["namespace"] != "":
        filename = module["namespace"].lower() + "."
    else:
        filename = ""
    filename += module["name"].lower() + "."
    with open("./modules/generated/" + filename + "json", "w", encoding="utf-8") as file:
        file.write(json.dumps(module, sort_keys=False, indent=4))

    print("All operations completed. Exiting...")
    sys.exit()


main()
