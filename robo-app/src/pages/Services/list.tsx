// Import de de pacotes
import React, { useCallback, useEffect, useState } from 'react';
import {
    Alert,
    Image,
    ImageBackground,
    Platform,
    ScrollView,
    StyleSheet,
    TouchableOpacity,
    View
} from 'react-native';
import { Dialog, Portal, RadioButton, Text, TextInput } from 'react-native-paper';
import { TouchableWithoutFeedback } from 'react-native-gesture-handler';
import { Fontisto, FontAwesome5 } from '@expo/vector-icons';
import DateTimePicker from '@react-native-community/datetimepicker';
import { StackScreenProps } from '@react-navigation/stack';
import { ParamListBase } from '@react-navigation/native';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import { Input } from '../../components/GlobalCSS';
import theme from "../../global/styles/theme";

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';
import imgTeste from '../../../assets/images/jetpack_logo.png';     //Imagem de teste
import api from '../../services/api';

export function RequestServices({ navigation }: StackScreenProps<ParamListBase>) {
    // Variáveis
    const [search, setSearch] = useState('');

    const [categorias, setCategorias] = useState([]);                           //Guarda o valor de todas as categorias
    const [subCategorias, setSubCategorias] = useState([]);                     //Guarda o valor de todas as subcategorias
    const [subFilter, setSubFilter] = useState([]);                             //Guarda o valor da subcategoria filtradas
    const [category, setCategory] = useState('');                               //Guarda o valor da categoria selecionada
    const [subCategory, setSubCategory] = useState('');                         //Guarda o valor da subcategoria selecionada

    const [showCat, setShowCat] = useState(false);                              //TRUE = mostra, FALSE = esconde CATEGORIAS
    const [showSubCat, setShowSubCat] = useState(false);                        //TRUE = mostra, FALSE = esconde SUBCATEGORIAS
    const [showFilter, setShowFilter] = useState(false);                        //TRUE = mostra, FALSE = esconde FILTROS

    const [data, setData] = useState([]);
    const [dataFilter, setDataFilter] = useState([]);

    const [showDate, setShowDate] = useState(false);                            //Abre o <Portal> para selecionar uma data
    const [hour, setHour] = useState(false);                                    //Avança a opção de data para hora
    const [day, setDay] = useState(false);                                      //Abre o <DateTimePicker> da data
    const [period, setPeriod] = useState(false);                                //Abre o <DateTimePicker> da hora
    // const [horaStart, setHoraStart] = useState(new Date(1609459200000));        //Horário inicial
    // const [horaFinish, setHoraFinish] = useState(new Date(1609459200000));      //Horário final
    const [date, setDate] = useState('');                                       //Salva a data
    const [time, setTime] = useState('');                                       //Salva a hora
    var dia = new Date();                                                       //Dia, Mês e Ano

    // Funções de dentro da página

    /* function currencyReal(numero) {
        if (isNaN(numero)) {
            return num = 'R$';
        }

        var num = 0;
        num = parseFloat(numero).toFixed(2);
        num = num.split('.');
        num[0] = `R$ ${num[0].split(/(?=(?:...)*$)/).join('.')}`;
        num = num.join(',');
        return num;
    } */

    // Função para adicionar 3 dias ao mínimo pedido
    Date.prototype.addDays = function (days) {
        let date = new Date();
        date.setDate(date.getDate() + days);
        return date;
    }

    // Setar o tempo
    const onChangeTime = (event, selectedTime) => {
        if (selectedTime === undefined) {
            selectedTime = dia.addDays(3);
        }
        const currentTime = selectedTime || time;
        setPeriod(Platform.OS === 'ios');
        setDate(currentTime);
        console.log('CURRENT TIME: ' + currentTime);
        setPeriod(false);
    }

    // Setar a data
    const onChangeDay = (event, selectedDate) => {
        if (selectedDate === undefined) {
            selectedDate = dia.addDays(3);
        }
        const currentDate = selectedDate || day;
        setDay(Platform.OS === 'ios');
        setDate(currentDate);
        console.log('CURRENT DATE: ' + currentDate);
        setDay(false);

    }

    useEffect(() => {
        if (category) {
            setDataFilter(
                data.filter((card) => {
                    return card.subcategories.length > 0 && card.subcategories.map(sub => {
                        return sub.subcategory.category.id === category;
                    })
                })
            )
        } else {
            setDataFilter(data);
        }
    }, [category, data]);

    useEffect(() => {
        if (subCategory) {
            setDataFilter(dataFilter.filter((card) => {
                return card.subcategories.map((sub) => {
                    return sub.subcategory.id === subCategory;
                });
            }));
            const teste = dataFilter.filter((card) => {
                return card.subcategories.map((sub) => {
                    return sub.subcategory.id === subCategory;
                });
            });
        }
    }, [subCategory]);

    function searchService(nome){
        // console.log('PESQUISA: ', dataFilter[0].name);
        
        setDataFilter(dataFilter.filter((card) => {
            return card.name.includes(nome);
        }));
    }

    // Executa ao carregar a página
    useEffect(() => {

        // setDate(dia.addDays(3));
        // setTime(dia.addDays(3));
        // setShowDate(false);
        // setHour(true);

        getCategorias();
        servicos();
    }, []);

    async function getCategorias() {
        try {
            const response = await api.get('category');
            setCategorias(response.data);
            const response2 = await api.get('subcategory');
            setSubCategorias(response2.data);

            console.log('RESPONSE2: %s', response2.data);

        } catch (e) { console.log(e.response.data.message); }
    }

    const servicos = async () => {
        const response = await api.get('user?filter=3');

        setData(response.data);

        console.log('RESPOSTA: %s', response.data[0].subcategories[2].price);
    }

    // Construção da página
    return (
        <>
            {/* Cabeçalho da página */}
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center'
                    }}
                >
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%'
                        }}
                    >
                        <Image source={logo}
                            resizeMode="contain"
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => { navigation.goBack() }} //Navegar para a Home
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
                        <Text style={styles.textStyleF}>
                            RoboComp - Lista de Serviços
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            {/* Meio da página */}
            <View style={{
                backgroundColor: '#F4F1F0',
                alignSelf: 'center',
                minWidth: '100%',
                height: '100%',
                alignItems: 'center'
            }}>
                <View style={{
                    flexDirection: 'column',
                    marginVertical: 20,
                    width: '100%',
                    alignItems: 'flex-start',
                    marginLeft: '7%',
                    marginRight: 0
                }}>
                    <View style={{
                        flexDirection: 'row',
                        alignItems: 'center',
                        paddingRight: '8%'
                    }}>
                        <View style={{ flexDirection: 'column' }}>
                            <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>Nome do Técnico:</Text>
                            <View style={styles.search}>
                                <TextInput
                                    value={search}
                                    onChangeText={(t) => setSearch(t)}
                                    style={styles.textInput}
                                />
                            </View>
                        </View>
                        <TouchableOpacity onPress={() => {searchService(search)}}>
                            {/* Adicionar a pesquisa de serviços na linha acima */}
                            <FontAwesome5
                                name='search'
                                colors={theme.colors.black}
                                size={40}
                            />
                        </TouchableOpacity>
                    </View>
                    <View style={{ flexDirection: 'row' }}>
                        <View style={{ marginBottom: 15 }}>
                            <View style={{ flexDirection: 'row', width: '95%', alignItems: 'baseline' }}>
                                <View style={{ flexDirection: 'column' }}>
                                    <TouchableOpacity style={styles.filter}
                                        onPress={() => { setShowCat(!showCat); setShowSubCat(false); setShowFilter(false) }}
                                    >
                                        <FontAwesome5
                                            name={(showCat) ? 'chevron-down' : 'chevron-right'}
                                            color={theme.colors.black}
                                            size={20}
                                        />
                                        <Text style={{ fontWeight: 'bold', marginHorizontal: 5 }}>Categorias</Text>
                                    </TouchableOpacity>
                                    {(showCat) &&
                                        <RadioButton.Group onValueChange={newValue => { setCategory(newValue); console.log(newValue) }} value={category}>
                                            {(categorias.map(cate => (
                                                <TouchableOpacity
                                                    style={{ flexDirection: 'row', width: '95%', alignItems: 'center' }}
                                                    onPress={() => { setCategory(cate.id); console.log(cate.id) }}
                                                >
                                                    <RadioButton value={cate.id} />
                                                    <Text>{cate.name}</Text>
                                                </TouchableOpacity>
                                            )))}
                                        </RadioButton.Group>
                                    }
                                </View>
                                <View style={{ flexDirection: 'column' }}>
                                    {(category !== '') && <TouchableOpacity style={styles.filter}
                                        onPress={() => { setShowCat(false); setShowSubCat(!showSubCat); setShowFilter(false) }}
                                    >
                                        <FontAwesome5
                                            name={(showSubCat) ? 'chevron-down' : 'chevron-right'}
                                            color={theme.colors.black}
                                            size={20}
                                        />
                                        <Text style={{ fontWeight: 'bold', marginHorizontal: 5 }}>Subcategorias</Text>
                                    </TouchableOpacity>
                                    }
                                    {(category !== '' && showSubCat) &&
                                        <RadioButton.Group onValueChange={newValue => { setSubCategory(newValue); console.log(newValue) }} value={subCategory}>
                                            {(subCategorias.map(cate2 => (
                                                (cate2.category_id === category) &&
                                                <TouchableOpacity style={{ flexDirection: 'row', width: '95%', alignItems: 'center' }}
                                                    onPress={() => { setSubCategory(cate2.id); console.log(cate2.id) }}
                                                >
                                                    <RadioButton value={cate2.id} />
                                                    <Text>{cate2.name}</Text>
                                                </TouchableOpacity>
                                            )))}
                                        </RadioButton.Group>
                                    }
                                </View>

                                <TouchableOpacity style={styles.filter}
                                    onPress={() => { setShowCat(false); setShowSubCat(false); setShowFilter(!showFilter) }}
                                >
                                    <FontAwesome5
                                        name={(showFilter) ? 'chevron-down' : 'chevron-right'}
                                        color={theme.colors.black}
                                        size={20}
                                    />
                                    <Text style={{ fontWeight: 'bold', marginHorizontal: 5 }}>Filtros</Text>
                                </TouchableOpacity>
                            </View>
                        </View>
                    </View>
                    <ScrollView>
                        {(dataFilter.map((d) => (
                            <>
                                <TouchableOpacity style={styles.anuncioCard}
                                    onPress={() => console.log('-->\n', d)}>
                                    <View style={styles.imageInfo}>
                                        <Image style={styles.imageCard} source={imgTeste} />
                                    </View>
                                    <View style={styles.adInfo}>
                                        {/* Título */}
                                        <Text style={styles.adTitle}>{d.name}</Text>
                                        {/* Preço */}
                                        <Text style={styles.adPrice}>{d.fullname}</Text>
                                        {/* Nome do servidor/técnico */}
                                        <Text>{d.phone}</Text>
                                        {/* Categoria do anúncio */}
                                        <View style={{
                                            flexDirection: 'row',
                                            marginBottom: 10,
                                            marginRight: 10,
                                            marginTop: 'auto',
                                        }}>
                                            <Text style={styles.adCategory}>{ }</Text>
                                        </View>
                                    </View>
                                    {/* Botão para adicionar direto ao carrinho */}
                                    <View style={{ marginVertical: 10, alignItems: 'center' }}>
                                        <TouchableOpacity
                                            style={{ marginTop: 0, marginBottom: 'auto' }}
                                            onPress={() => {
                                                setShowDate(true);
                                                setDay(true);
                                                console.log('setShowDate(true)\nset ID do cliente\nset subcategoria\nset do preço')
                                                setDate(dia.addDays(3));
                                                setTime(dia.addDays(3));
                                            }}
                                        >
                                            <FontAwesome5
                                                name='cart-plus'
                                                color={theme.colors.black}
                                                size={24}
                                            />
                                        </TouchableOpacity>
                                        <View style={{ marginLeft: -15 }}>
                                            <Fontisto
                                                name='star'
                                                size={40}
                                                color={theme.colors.star}
                                            />
                                            <Text style={{
                                                position: 'absolute',
                                                alignSelf: 'center',
                                                paddingTop: '33%'
                                            }}>{!d.total_rating ? '5.0' : d.total_rating}</Text>
                                        </View>
                                    </View>
                                </TouchableOpacity>
                            </>
                        )))}
                    </ScrollView>
                </View>
            </View>
        </>
    );
};

const styles = StyleSheet.create({
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    scrollView: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
        paddingTop: 5,
        flexGrow: 1,
        marginBottom: '43%',
    },
    scrollView2: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
        paddingTop: 5,
        flexGrow: 1,
        height: '46%',
    },
    scrollView3: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
        paddingTop: 5,
        flexGrow: 1,
        height: '32%',
    },
    adInfo: {
        width: '55%',
        marginTop: 5,
    },
    anuncioCard: {
        flexDirection: 'row',
        height: 160,
        width: '95%',
        marginBottom: 10,
        borderRadius: 20,
        backgroundColor: '#FFF',
    },
    imageInfo: {
        width: '30%',
        height: '100%',
        marginRight: '3%',
    },
    imageCard: {
        width: '100%',
        height: '100%',
        borderTopLeftRadius: 20,
        borderBottomLeftRadius: 20,
        borderWidth: 1,
        borderColor: theme.colors.black,
    },
    deleteIcon: {
        alignSelf: 'flex-start',
        marginRight: '2%',
        marginTop: '2%',
    },
    editIcon: {
        marginTop: '2%',
        marginBottom: '55%',
    },
    adTitle: {
        fontWeight: 'bold',
        marginRight: '30%',
    },
    adPrice: { fontWeight: 'bold', marginTop: 20 },
    adCategory: {
        textAlign: 'justify',
        height: 'auto',
        width: '60%',
    },
    filter: {
        flexDirection: 'row',
        alignItems: 'center',
        width: 'auto'
    },
    filter2: {
        flexDirection: 'row',
        alignItems: 'center',
        marginRight: 5,
        marginLeft: 'auto',
    },
    search: {
        flexDirection: 'row',
        alignItems: 'center',
        marginVertical: 5,
    },
    textInput: {
        height: 30,
        marginLeft: 5,
        width: '80%',
        borderRadius: 8,
        borderColor: 'transparent',
        borderWidth: 1,
        backgroundColor: '#FFF',
    },
    touchOptions: {
        flexDirection: 'row',
        alignItems: 'center',
    },
});