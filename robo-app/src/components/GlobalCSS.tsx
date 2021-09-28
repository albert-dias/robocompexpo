import { View } from "react-native";
import { Title, TextInput } from "react-native-paper";
import styled from "styled-components/native";

import theme from "../global/styles/theme";

interface InputProps {
    width?: string;
}

export const Input = styled(TextInput) <InputProps>`
    width: ${({ width }) => width ?? '100%'};
    height: 60px;
    background-color: rgba(0,0,0,0);
    color: ${theme.colors.textOnSurface};
`;

export const GroupControl = styled(View)`
    padding: 10px;
    width: 100%;
`;

export const PanelTitle = styled(Title)`
    display: flex;
    font-size: 25px;
    margin: 0 auto;
`;

export const TitleView = styled(View)``;

export const TitleWrapper = styled(View)`
    position: relative;
    align-items: center;
    justify-content: center;
    padding: 40px;
    width: 100%;
`;