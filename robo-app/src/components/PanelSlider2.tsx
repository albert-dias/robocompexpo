// Import de pacotes
import styled from "styled-components/native";
import { Surface } from "react-native-paper";

// Import de páginas
import theme from "../global/styles/theme";
import { DIMENSIONS_HEIGHT, DIMENSIONS_WIDTH } from "./Screen";

const PanelSlider = styled(Surface)`
    flex-direction: column;
    margin-left: ${DIMENSIONS_WIDTH * 0.05}px;
    margin-right: ${DIMENSIONS_WIDTH * 0.05}px;
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
    position: relative;
    padding: 16px;
    padding-top: 20px;
    width: ${DIMENSIONS_WIDTH * 0.9}px;
    height: ${DIMENSIONS_HEIGHT * 0.55}px;
    background-color: ${theme.colors.white};
`;

export default PanelSlider;