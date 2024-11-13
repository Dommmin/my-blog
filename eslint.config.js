import globals from "globals";
import pluginJs from "@eslint/js";
import tseslint from "typescript-eslint";
import pluginVue from "eslint-plugin-vue";

export default [
    {files: ["**/*.{js,mjs,cjs,ts,vue}"]},
    {files: ["**/*.js"], languageOptions: {sourceType: "commonjs"}},
    {languageOptions: { globals: globals.browser }},
    pluginJs.configs.recommended,
    ...tseslint.configs.recommended,
    ...pluginVue.configs["flat/essential"],
    {files: ["**/*.vue"], languageOptions: {parserOptions: {parser: tseslint.parser}}},
    {
        rules: {
            'no-unused-vars': 'off',
            'no-undef': 'off',
            'no-empty-function': 'error',
            'vue/multi-word-component-names': 'off',
            'vue/no-v-text-v-html-on-component': 'off',
            '@typescript-eslint/no-unused-vars': 'warn',
        }
    },
];
