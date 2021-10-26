// Import de pacotes
import React, { useEffect, useState } from 'react';
import { Alert, Image, ImageBackground, StyleSheet, TouchableOpacity, View, } from 'react-native';
import { Text } from 'react-native-paper';
import { ScrollView } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import request from '../../util/request';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function ShoppingCart() {
    //Variáveis
    const [loading, setLoading] = useState(false);

    const [product, setProduct] = useState([null]);
    const [total, setTotal] = useState(0);

    // Funções da página

    function currencyReal(numero) {
        var num = 0;
        if (isNaN(numero)) {
            return num = 'R$ 0,00';
        }

        num = parseFloat(numero).toFixed(2);
        num = num.split('.');
        num[0] = `R$ ${num[0].split(/(?=(?:...)*$)/).join('.')}`;
        num = num.join(',');
        return num;
    }

    function currencyReal2(numero, produto) {
        var x = 0, y = 0, num = 0;
        if (product !== null) {
            while (produto[x] !== undefined) {
                y += produto[x].price;
                x++;
            }
        }
        if (isNaN(numero)) {
            return num = 'R$0,00';
        }

        num = y.toFixed(2).split('.');
        num[0] = `R$ ${num[0].split(/(?=(?:...)*$)/).join('.')}`;
        num = num.join(',');
        return num;
    }

    useEffect(() => {
        var x = 0;
    }, []);

    // Construção da página
    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}
                >
                    <Container
                        pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}
                    >
                        <Image
                            source={logo}
                            resizeMode="contain"
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => { console.log('navigate(RequestServices)') }}
                            style={{
                                position: 'absolute',
                                alignSelf: 'flex-start',
                                marginLeft: '5%',
                                alignContent: 'flex-start',
                                alignItems: 'flex-start',
                            }}
                        >
                            <FontAwesome5
                                name='chevron-left'
                                color={theme.colors.white}
                                size={40}
                            />
                        </TouchableOpacity>
                        <Text style={styles.textStyleF}>Robocomp - Carrinho de Compras</Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <View style={{ flexDirection: 'column', backgroundColor: theme.colors.gray }}>
                <ScrollView style={styles.scrollView}>
                    {/* {(product == null) ? <View/> :
                            (product.length > 0) ?
                                product.map((prod,index) => (
                                    (prod !== null) ? 
                    */}
                    <View /* key={index} */ style={styles.anuncioCard}>
                        <Text style={styles.anuncioTitle}>Nome do serviço</Text>
                        <Text style={styles.anuncioPrice}>{currencyReal(1000)}</Text>
                        <TouchableOpacity
                            style={styles.anuncioIcon}
                            onPress={()=>{
                                Alert.alert("AVISO",
                                "Você deseja retirar este produto do carrinho?",
                                [{
                                    text: "SIM",
                                    onPress: () => {console.log('Deletar serviço')},
                                    style: 'default',
                                },{
                                    text: "NÃO",
                                    onPress: () => {},
                                    style: 'cancel',
                                }],{cancelable: false});
                            }}
                        >
                            <FontAwesome5
                                name='trash-alt'
                                color={theme.colors.red}
                                size={20}
                            />
                        </TouchableOpacity>
                    </View>
                    {/* :<View/>
                    )):<View style={{alignItems: 'center'}}><Text>O carrinho de compras está vazio</Text></View>}
                    */}
                </ScrollView>
            </View>
        </>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: theme.colors.gray,
    },
    anuncioCard: {
        flexDirection: 'row',
        minHeight: 50,
        width: '90%',
        marginHorizontal: '5%',
        marginVertical: '1%',
        borderRadius: 8,
        borderWidth: 1,
        borderColor: 'black',
        alignItems: 'center',
        marginBottom: '5%',
    },
    anuncioIcon: {
        flex: 1,
        marginHorizontal: 0,
    },
    anuncioTitle: {
        flex: 3,
        fontSize: 16,
        alignItems: 'flex-start',
        marginLeft: '4%',
        fontWeight: 'bold',
    },
    anuncioPrice: {
        flex: 2,
        fontSize: 16,
        alignItems: 'center',
        marginHorizontal: 0,
    },
    scrollView: {
        backgroundColor: theme.colors.gray,
        marginHorizontal: 0,
        paddingTop: 5,
        flexGrow: 1,
        marginBottom: 'auto',
        borderTopWidth: 1,
        borderTopColor: theme.colors.black,
        height: '100%',
    },
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    confirmArea: {
        backgroundColor: theme.colors.gray,
        width: '100%',
        height: '22%',
        alignItems: 'center',
        justifyContent: 'flex-end',
        paddingBottom: '2%',
        borderTopColor: '#444',
        borderWidth: 0.5,
    },
    confirmButton: {
        alignItems: 'center',
        backgroundColor: theme.colors.background,
        padding: 10,
        borderRadius: 80,
    },
    confirmText: {
        fontWeight: 'bold',
        color: '#fff',
    },
    confirmText2: {
        fontSize: 16,
        fontWeight: 'bold',
        paddingRight: 5,
        paddingBottom: 5,
        color: theme.colors.black,
    },
    confirmPrice: {
        fontSize: 16,
        fontWeight: 'bold',
        paddingRight: 5,
        paddingBottom: 5,
        color: theme.colors.black,
    },
});