// Import de pacotes
import { StyleSheet } from "react-native";
import { TextInput } from "react-native-paper";
import styled from "styled-components/native";

const styles = StyleSheet.create({
    textInput: {
      backgroundColor: '#fff',
    },
  });

interface InputProps {
    width?: string;
    setValue: (value: string) => void;
}

export const Input = styled(TextInput) <InputProps>`
    width: ${({ width }) => width ?? '100%'};
    height: 60px;
    background-color: rgba(0, 0, 0, 0);
    color: ${({ theme }) => theme.colors.textOnSurface};
`;