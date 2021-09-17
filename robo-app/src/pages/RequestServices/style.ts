// Import de pacotes
import { View } from "react-native";
import { Text, TextInput } from "react-native-paper";
import styled from "styled-components/native";

// Import de páginas
import theme from "../../global/styles/theme";

interface InputProps {
    width?: string;
}

export const Input = styled(TextInput) <InputProps>`
    width: ${({ width }) => width ?? '100%'};
    height: 60px;
    background-color: rgba(0, 0, 0, 0);
    color: ${({ theme }) => theme.colors.textOnSurface};
`;