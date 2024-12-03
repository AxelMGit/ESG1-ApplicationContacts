#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define MEMORY_SIZE 256

void to_bin(const char *assembly, const char *output_file);
void ld_bin(const char *binary_file);
void ex_bin(const unsigned char *memory, size_t size);

int main() {
    char assembly_code[] =
        "MOV 5\n"
        "ADD 10\n"
        "SUB 3\n"
        "HALT\n"; // Quelques instructions pour l'ex

    const char *binary_file = "hexa.txt";

    to_bin(assembly_code, binary_file);
    ld_bin(binary_file);

    return 0;
}

// Convert. l'assembleur en bin et save
void to_bin(const char *assembly, const char *output_file) {
    FILE *file = fopen(output_file, "w");
    if (!file) {
        perror("Erreur d'ouverture du fichier binaire");
        exit(EXIT_FAILURE);
    }

    char line[256];
    const char *delimiter = "\n";
    char *instruction;
    char *assembly_copy = strdup(assembly);  // Faire une copie pour strtok

    unsigned char binary[MEMORY_SIZE];
    size_t index = 0;

    instruction = strtok(assembly_copy, delimiter);
    while (instruction != NULL) {
        char opcode[16];
        int operand = 0;

        // "Dict" dont je t'ai parlé (idéalement l'externaliser par la suite)
        if (sscanf(instruction, "%s %d", opcode, &operand) == 2 || sscanf(instruction, "%s", opcode) == 1) {
            if (strcmp(opcode, "MOV") == 0) {
                binary[index++] = 0x01;
                binary[index++] = (unsigned char)operand;
            } else if (strcmp(opcode, "ADD") == 0) {
                binary[index++] = 0x02;
                binary[index++] = (unsigned char)operand;
            } else if (strcmp(opcode, "SUB") == 0) {
                binary[index++] = 0x03;
                binary[index++] = (unsigned char)operand;
            } else if (strcmp(opcode, "HALT") == 0) {
                binary[index++] = 0xFF;
            } else {
                fprintf(stderr, "Instruction inconnue: %s\n", opcode);
            }
        }
        instruction = strtok(NULL, delimiter);
    }

    for (size_t i = 0; i < index; i++) {
        fprintf(file, "%02X ", binary[i]);
    }
    fprintf(file, "\n");

    fclose(file);
    free(assembly_copy);
}

// Lecture du bin
void ld_bin(const char *binary_file) {
    FILE *file = fopen(binary_file, "r");
    if (!file) {
        perror("Erreur d'ouverture du fichier binaire");
        exit(EXIT_FAILURE);
    }

    unsigned char memory[MEMORY_SIZE] = {0};
    size_t index = 0;
    unsigned int value;

    // Lecture du bin en memoire
    while (fscanf(file, "%02X", &value) == 1 && index < MEMORY_SIZE) {
        memory[index++] = (unsigned char)value;
    }
    fclose(file);

    // Exec le bin
    ex_bin(memory, index);
}

// Exec le bin
void ex_bin(const unsigned char *memory, size_t size) {
    size_t ip = 0;  // Instruction Pointer
    int accumulator = 0;

    printf("Début de l'exécution :\n");

    while (ip < size) {
        unsigned char opcode = memory[ip++];
        switch (opcode) {
            case 0x01:  // MOV
                accumulator = memory[ip++];
                printf("MOV %d -> ACC\n", accumulator);
                break;
            case 0x02:  // ADD
                accumulator += memory[ip++];
                printf("ADD -> ACC = %d\n", accumulator);
                break;
            case 0x03:  // SUB
                accumulator -= memory[ip++];
                printf("SUB -> ACC = %d\n", accumulator);
                break;
            case 0xFF:  // HALT
                printf("HALT\n");
                return;
            default:
                printf("Instruction inconnue: 0x%02X\n", opcode);
                return;
        }
    }
}
