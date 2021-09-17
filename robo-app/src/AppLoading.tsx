// Import de pacotes
import 'react-native-gesture-handler';
import React from 'react';
import {
    Image,
    StatusBar,
    StyleSheet,
    Text,
    TouchableHighlight,
    TouchableOpacity,
    View
} from 'react-native';
import Swiper from 'react-native-swiper';

// Import de imagens
import slide1 from '../assets/images/wizard_01.png';
import slide2 from '../assets/images/wizard_02.png';
import slide3 from '../assets/images/wizard_03.png';
import logo from '../assets/images/Logo-Grupo-Ecomp.png';

// Botão de SKIP da TELA INICAL
const SkipButton = ({ onPress }) => {
    return (
        <View style={styles.pularView}>
            <TouchableOpacity onPress={onPress}>
                <Text style={styles.pularText}>Pular</Text>
            </TouchableOpacity>
        </View>
    );
};

// Função principal da TELA INICIAL
export function AppLoading() { //Add {navigation}
    StatusBar.setHidden(true);

    return (
        <Swiper
            showsPagination={true}
            style={styles.wrapper}
            loop={false}
        >
            {/* SLIDE 1 */}
            <View style={styles.slide}>
                <Image source={logo} />

                <View style={styles.image1}>
                    <Image source={slide1} style={styles.slides} />
                    <Text style={styles.title1}>Somos uma plataforma de Gerenciamento de Serviços de TI.</Text>
                    <SkipButton onPress={() => { console.log('Ir para a página de Selecionar Perfil') }} />
                </View>
            </View>

            {/* SLIDE 2 */}
            <View style={styles.slide}>
                <Image source={logo} />

                <View style={styles.image1}>
                    <Image source={slide2} style={styles.slides} />
                    <Text style={styles.title1}>Abra chamados e encontre a melhor empresa de TI para resolver seu problema.</Text>
                    <SkipButton onPress={() => { console.log('Ir para a página de Selecionar Perfil') }} />
                </View>
            </View>
            {/* SLIDE 3 */}
            <View style={styles.slide}>
                <Image source={logo} />
                <View style={styles.containerCenter}>
                    <View style={styles.image1}>
                        <Image source={slide3} />
                        <Text style={styles.title1}>
                            O Robocomp é uma plataforma inteligente que simplifica a resolução
                            dos seus problemas de TI
                        </Text>
                    </View>
                </View>
                <View style={styles.prontoContainer}>
                    <TouchableHighlight
                        style={styles.pronto}
                        onPress={() => { console.log('Ir para a página de Selecionar Perfil') }}>
                        <Text style={styles.font}>Pronto</Text>
                    </TouchableHighlight>
                </View>
            </View>
        </Swiper>
    );
}

const styles = StyleSheet.create({
    wrapper: { backgroundColor: '#ccc' },
    slide: {
        flex: 1,
        alignItems: 'center',
        marginTop: '8%',
        backgroundColor: '#ccc',
    },
    image1: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
    },
    containerCenter: {
        flex: 1,
        justifyContent: 'center',
        marginTop: 50,
    },
    item: {
        flexDirection: 'row',
        justifyContent: 'flex-start',
        alignItems: 'center',
        paddingLeft: '20%',
        paddingRight: '20%',
        // backgroundColor: '#888',
        marginBottom: 20,
    },
    descricaoUsuario: {
        flexDirection: 'column',
        paddingLeft: '5%',
        paddingRight: '20%',
    },
    textoWizard3: {
        //paddingLeft: '5%',
        //paddingRight: '20%',
        alignItems: 'center',
        fontSize: 16,
        textAlign: 'justify',
        marginLeft: 5,
    },
    textoCabecalhoWizard3: {
        fontWeight: 'bold',
        // backgroundColor: '#ccc',
        fontSize: 18,
        textAlign: 'left',
        alignItems: 'center',
        marginBottom: 10,
        marginRight: 0,
        marginLeft: 5,
    },
    title1: {
        marginTop: 10,
        fontSize: 18,
        paddingHorizontal: 30,
        textAlign: 'center',
        letterSpacing: 1,
    },
    slide3: {
        flex: 1,
        alignItems: 'center',
        backgroundColor: '#92BBD9',
    },
    text: {
        color: '#fff',
        fontSize: 30,
        fontWeight: 'bold',
    },
    texto: {
        flex: 1,
        justifyContent: 'flex-end',
        alignItems: 'center',
    },
    prontoContainer: {
        justifyContent: 'flex-end',
        marginBottom: 50,
        alignItems: 'center',
    },
    pronto: {
        backgroundColor: '#03a4a9',
        borderRadius: 30,
        padding: 10,
        width: 100,
    },
    font: {
        fontSize: 16,
        color: '#fff',
        textAlign: 'center',
    },
    pularView: {
        position: 'absolute',
        bottom: '8%',
        right: '10%',
    },
    pularText: {
        fontSize: 20,
        color: '#FFF',
        backgroundColor: '#03A4A9',
        width: 100,
        textAlign: 'center',
        paddingVertical: 10,
        borderRadius: 25,
    },
    slides: { marginTop: '-15%', marginBottom: 10 },
});